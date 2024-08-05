<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ShoppingCart;

class ShoppingCartsController extends Controller
{

    public function showCart()
    {
        try {
            // Si no estass logado redirige al login
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            DB::beginTransaction();
            //Obtenemos el cliente
            $client = Auth::user();
            //Obtenemos el primer carritto de la compra del cliente
            $shoppingCart = ShoppingCart::where('user_id', $client->id)->first();

            //Comprobamos que el carrito de la compra no es nuelo
            if (!$shoppingCart) {
                return back()->with('error', 'El carrito de compra no existe.');
            }

            //Obtenemos los productos que contiene un carrito de la compra
            $products = $shoppingCart->products();

            //Comprobamos que tiene algun producto el carrito
            if (!$products) {
                return back()->with('error', 'El carrito de compra no contiene productos.');
            }

            // Commit la transacción si todo está bien
            DB::commit();

            return view('shoppingCart.index', compact('shoppingCart', 'products'));
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Error al mostrar el carrito de la compra.');
        }
    }



    public function addCart(Request $request)
    {
        try {

            // Si no estass logado redirige al login
            if (!Auth::check()) {
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
                dd('no hay stock');
                return back()->with('error', 'No hay stock disponible.');
            } else {
                //Comprobamos si el cliente tiene un carrito activo
                $shoppingCart = ShoppingCart::where('user_id', $client->id)->first();
                if ($shoppingCart == null) {
                    //Si no tiene carrito activo creamos uno
                    $shoppingCart = new ShoppingCart();
                    $shoppingCart->user_id = $client->id;
                    $shoppingCart->save();
                }
                //Comprobamos si el producto ya esta en el carrito
                $products_cart = $shoppingCart->products()->where('product_id', $product_id)->first();
                if ($products_cart != null) {
                    $shoppingCart->products()->updateExistingPivot($product_id, [
                        'quantity' => $products_cart->pivot->quantity + 1,
                        'total_price' => $products_cart->pivot->total_price + $product->price
                    ]);
                } else {
                    //Si no esta en el carrito lo añadimos
                    $shoppingCart->products()->attach($product_id, [
                        'quantity' => 1,
                        'total_price' => $product->price
                    ]);
                }

                //Actualizamos el precio total del carrito
                $shoppingCart->total_price += $product->price;
                //Actualizamos la cantidad de productos del carrito
                $shoppingCart->quantity += 1;
                //GUARDAMOS EN LA BBDD  
                $shoppingCart->save();

                //Actualizamos el stock del producto
                $product->stock -= 1;
                $product->save();
                DB::commit();
                return back()->with('success', 'Producto añadido al carrito.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
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
