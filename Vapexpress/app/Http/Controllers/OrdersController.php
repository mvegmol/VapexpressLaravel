<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Address;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendOrderConfirmationMail;

class OrdersController extends Controller
{

    public function index_admin(Request $request)
    {
        // Comprobamos si hay una búsqueda
        $query = $request->input('search');
        // Comprobamos si se va ordenar por algún campo
        $sortField = $request->input('sort', 'id');
        // Comprobamos si la dirección para ordenar es ascendente o descendente
        $sortDirection = $request->input('direction', 'asc');

        // Aseguramos que la columna sortField es válida
        $validSortFields = ['id', 'total_price'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'id';
        }

        $orders = Order::with(['products', 'user'])->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where(function ($q) use ($query) {
                $q->where('id', 'like', "%{$query}%")
                    ->orWhere('status', 'like', "%{$query}%")
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    });
            });
        })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);

        if ($orders->isEmpty()) {
            return redirect()->route("orders.admin.index")
                ->with("error", "No se han encontrado resultados de la consulta realizada: $query");
        }

        return view("admin.orders.index", compact("orders", "query", "sortField", "sortDirection"));
    }



    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->input('status')]);
        return redirect()->route('orders.admin.index')->with('success', 'Estado del pedido actualizado correctamente');
    }

    public function show_admin(Order $order)
    {

        // Cargar la relación con los productos y el usuario
        $order->load('products', 'user');

        return view("admin.orders.show", compact("order"));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {



            DB::beginTransaction();

            // Retrieve the authenticated user's shopping cart
            $shoppingCart = ShoppingCart::where('user_id', Auth::id())->first();

            if (!$shoppingCart || $shoppingCart->products->isEmpty()) {
                return redirect()->route('home')->with('error', 'El carrito de compra está vacío.');
            }
            $addressId_id = session('selected_address_id');

            $address = Address::find($addressId_id);
            $fullAddress = sprintf(
                "%s %s %s, %s %s Tel: %s",
                $address->full_name,
                $address->direction,
                $address->city,
                $address->province,
                $address->zip_code,
                $address->contact_phone
            );

            // Create a new order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $shoppingCart->total_price,
                'address' => $fullAddress,
                'status' => 'Pending',
                'order_date' => Carbon::now(),
            ]);

            foreach ($shoppingCart->products as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->total_price,
                ]);
            }

            //Enviamos un correo de confirmacion al usuario de que ha tramitado correctamente el pedido
            Mail::to(Auth::user()->email)->send(new SendOrderConfirmationMail($order, $shoppingCart->products, Auth::user()->email));

            $shoppingCart->products()->detach();
            $shoppingCart->delete();

            DB::commit();

            return redirect()->route('home')->with('success', 'Pedido realizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('home')->with('error', 'Error al procesar el pedido.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
