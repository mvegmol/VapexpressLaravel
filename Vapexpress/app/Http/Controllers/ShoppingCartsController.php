<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ShoppingCart;

class ShoppingCartsController extends Controller
{

    public function addCart(Request $request)
    {
        try {

            // Si no estass logado redirige al login
            if (Auth::check() == false) {
                return redirect()->route('login');
            }

            DB::beginTransaction();
            $product_id = $request->product_id;
            //Obteneemos el cliente
            $client = Auth::user();
            //Obtenemos el producto
            $product = Product::find($product_id);

            //Comprobamos si el producto tiene stock disponible 
            if ($product->stock < 1) {
                return back()->with('error', 'No hay stock disponible.');
            } else {
                //Comprobamos si el cliente tiene un carrito activo
                if ($client->shoppingCart == null) {
                    //Si no tiene carrito activo creamos uno
                    $shoppingCart = new ShoppingCart();
                    $shoppingCart->user_id = $client->id;
                    $shoppingCart->save();
                } else {
                    //Si tiene carrito activo lo obtenemos
                    $shoppingCart = $client->shoppingCart;
                }

                //Comprobamos si el producto ya esta en el carrito
                if ($shoppingCart->products->contains($product)) {
                    //Si ya esta en el carrito aumentamos la cantidad
                    $productInCart = $shoppingCart->products()->where('product_id', $product_id)->first();
                    $productInCart->pivot->quantity += 1;
                    $productInCart->pivot->total_price = $productInCart->pivot->quantity * $product->price;
                    $productInCart->pivot->save();
                } else {
                    //Si no esta en el carrito lo añadimos
                    $shoppingCart->products()->attach($product_id, ['quantity' => 1, 'total_price' => $product->price]);
                }

                //Actualizamos el stock del producto
                $product->stock -= 1;
                $product->save();
                DB::commit();
                return back()->with('success', 'Producto añadido al carrito.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al añadir el producto al carrito.');
        }
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
