<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ShoppingCart;

class ShoppingCartsController extends Controller
{


    public function checkout(Request $request)
    {
        try {
            // Si no estás logado redirige al login y si eres admin te redirige al home
            if (!Auth::check()) {
                return redirect()->route('login');
            } else if (Auth::user()->role == 'admin') {
                return redirect()->route('home');
            }

            DB::beginTransaction();
            $client = Auth::user();
            // Obtenemos todas las direcciones del cliente
            $addresses = $client->address;
            $shoppingCart = ShoppingCart::where('user_id', $client->id)->first();

            // Comprobamos que el carrito de la compra no es nulo
            if (!$shoppingCart || $shoppingCart->products()->count() === 0) {
                return redirect()->route('shopping_cart')->with('error', 'El carrito de compra está vacío.');
            }
            session(['previous_url' => url()->previous()]);
            DB::commit();
            return view('client.checkout', compact('addresses', 'shoppingCart'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al tramitar el pedido.');
        }
    }




    public function showCart()
    {
        try {
            // Si no estas logado redirige al login y si eres admin te redirige al home
            if (!Auth::check()) {
                return redirect()->route('login');
            } else if (Auth::user()->role == 'admin') {
                return redirect()->route('home');
            }

            DB::beginTransaction();
            // Obtenemos el cliente
            $client = Auth::user();
            // Obtenemos el primer carrito de la compra del cliente
            $shoppingCart = ShoppingCart::where('user_id', $client->id)->first();

            // Comprobamos que el carrito de la compra no es nulo
            if (!$shoppingCart) {
                return back()->with('error', 'El carrito de compra no existe.');
            }

            // Obtenemos los productos que contiene un carrito de la compra con categorías
            $products = $shoppingCart->products()->with('categories')->get();

            // Comprobamos que tiene algún producto el carrito
            if ($products->isEmpty()) {
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
            // Si no estás logueado redirige al login y si eres admin te redirige al home
            if (!Auth::check()) {
                return redirect()->route('login');
            } else if (Auth::user()->role == 'admin') {
                return redirect()->route('home');
            }

            DB::beginTransaction();

            $product_id = $request->product_id;
            $quantity_to_add = intval($request->quantity);

            //Obtenemos el cliente
            $client = Auth::user();
            //Obtenemos el producto
            $product = Product::find($product_id);

            //Comprobamos si el producto tiene suficiente stock disponible 
            if ($product->stock < $quantity_to_add) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            } else {
                //Comprobamos si el cliente tiene un carrito activo
                $shoppingCart = ShoppingCart::where('user_id', $client->id)->first();
                if ($shoppingCart == null) {
                    //Si no tiene carrito activo creamos uno
                    $shoppingCart = new ShoppingCart();
                    $shoppingCart->user_id = $client->id;
                    $shoppingCart->save();
                }

                //Comprobamos si el producto ya está en el carrito
                $products_cart = $shoppingCart->products()->where('product_id', $product_id)->first();
                if ($products_cart != null) {
                    // Actualizamos la cantidad y el precio total en el carrito
                    $shoppingCart->products()->updateExistingPivot($product_id, [
                        'quantity' => $products_cart->pivot->quantity + $quantity_to_add,
                        'total_price' => $products_cart->pivot->total_price + ($product->price * $quantity_to_add)
                    ]);
                } else {
                    // Si no está en el carrito lo añadimos
                    $shoppingCart->products()->attach($product_id, [
                        'quantity' => $quantity_to_add,
                        'total_price' => $product->price * $quantity_to_add
                    ]);
                }

                // Actualizamos el precio total del carrito
                $shoppingCart->total_price += $product->price * $quantity_to_add;
                // Actualizamos la cantidad de productos del carrito
                $shoppingCart->quantity += $quantity_to_add;
                // Guardamos el carrito en la base de datos
                $shoppingCart->save();

                // Actualizamos el stock del producto

                $cantidad_anterior = $product->stock;
                $product->stock -= $quantity_to_add;
                // dd($product->stock, $cantidad_anterior);

                $product->save();

                DB::commit();
                return back()->with('success', 'Producto añadido al carrito.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al añadir el producto al carrito.');
        }
    }



    public function updateQuantity(Request $request, $productId)
    {
        try {
            // Si no estass logado redirige al login y si eres admin te redirige al home
            if (!Auth::check()) {
                return redirect()->route('login');
            } else if (Auth::user()->role == 'admin') {
                return redirect()->route('home');
            }

            DB::beginTransaction();
            $client = Auth::user();
            $shoppingCart = ShoppingCart::where('user_id', $client->id)->first();

            if (!$shoppingCart) {
                return back()->with('error', 'El carrito de compra no existe.');
            }

            $product = $shoppingCart->products()->where('product_id', $productId)->first();
            if ($product) {
                $newQuantity = $request->quantity;
                $difference = $newQuantity - $product->pivot->quantity;

                if ($difference > 0 && $product->stock < $difference) {
                    return back()->with('error', 'No hay stock suficiente disponible.');
                }

                $shoppingCart->products()->updateExistingPivot($productId, [
                    'quantity' => $newQuantity,
                    'total_price' => $newQuantity * $product->price
                ]);

                $shoppingCart->total_price += $difference * $product->price;
                $shoppingCart->quantity += $difference;
                $shoppingCart->save();

                $product->stock -= $difference;
                $product->save();
            }

            DB::commit();
            return back()->with('success', 'Cantidad del producto actualizada.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Error al actualizar la cantidad del producto.');
        }
    }

    public function destroy($productId)
    {
        try {
            // Si no estass logado redirige al login y si eres admin te redirige al home
            if (!Auth::check()) {
                return redirect()->route('login');
            } else if (Auth::user()->role == 'admin') {
                return redirect()->route('home');
            }

            DB::beginTransaction();
            $client = Auth::user();
            $shoppingCart = ShoppingCart::where('user_id', $client->id)->first();

            if (!$shoppingCart) {
                return back()->with('error', 'El carrito de compra no existe.');
            }

            $product = $shoppingCart->products()->where('product_id', $productId)->first();
            if ($product) {
                $quantity = $product->pivot->quantity;
                $totalPrice = $product->pivot->total_price;

                // Remove product from cart
                $shoppingCart->products()->detach($productId);

                // Update shopping cart totals
                $shoppingCart->total_price -= $totalPrice;
                $shoppingCart->quantity -= $quantity;
                $shoppingCart->save();

                // Update product stock
                $product->stock += $quantity;
                $product->save();
            }

            DB::commit();
            return back()->with('success', 'Producto eliminado del carrito.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Error al eliminar el producto del carrito.');
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
}
