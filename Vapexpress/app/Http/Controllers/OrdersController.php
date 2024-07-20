<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

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
        //
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
