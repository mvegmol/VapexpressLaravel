<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\ShoppingCart;

class StripeController extends Controller
{
    //
    public function index()
    {
        return view('stripe.index');
    }

    public function checkout(Request $request)
    {

        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        // Validate the incoming request to ensure an address is selected
        $request->validate([
            'address' => 'required|exists:addresses,id',
        ]);
        //Ahora crearemos una session para guardar la direccion que es
        //seleccionada por el usuario
        session(['selected_address_id' => $request->address]);
        $shoppingCart = ShoppingCart::where('user_id', auth()->id())->first();

        if (!$shoppingCart || $shoppingCart->products->isEmpty()) {
            return redirect()->route('shopping_cart')->with('error', 'El carrito de compra está vacío.');
        }

        // Retrieve the selected address
        $address = Address::find($request->address);

        $lineItems = [];

        // Add products to the Stripe line items
        foreach ($shoppingCart->products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price * 100, // Stripe requires the amount in cents
                ],
                'quantity' => $product->pivot->quantity,
            ];
        }

        $shipping_cost = $shoppingCart->total_price < 50 ? 500 : 0; // Calculate shipping cost

        // Add shipping cost as a separate line item if applicable
        if ($shipping_cost > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Shipping Cost',
                    ],
                    'unit_amount' => $shipping_cost,
                ],
                'quantity' => 1,
            ];
        }

        // Create a new Stripe Checkout Session
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.index'),

            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => [
                            'amount' => $shipping_cost,
                            'currency' => 'eur',
                        ],
                        'display_name' => 'Standard Shipping',
                        'delivery_estimate' => [
                            'minimum' => [
                                'unit' => 'business_day',
                                'value' => 3,
                            ],
                            'maximum' => [
                                'unit' => 'business_day',
                                'value' => 5,
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        //Redirigimos para poder crear el pedido, eliminar el carrito y mostrar un mensaje de éxito. También se enviará un correo electrónico al usuario.
        return view('stripe.success');
    }
}
