<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ShoppingCartsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Desactiva la verificación CSRF solo para pruebas
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function guest_users_are_redirected_to_login_when_checkout()
    {
        $response = $this->get(route('shopping_cart.checkout'));
        // Comprueba que el usuario es redirigido a la página de login
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_users_are_redirected_to_home_when_checkout()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->get(route('shopping_cart.checkout'));
        // Comprueba que el usuario es redirigido a la página principal
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function user_can_checkout_with_non_empty_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear un producto y agregarlo al carrito de compras
        $product = Product::factory()->create(['stock' => 10]);
        $cart = ShoppingCart::create(['user_id' => $user->id]);
        $cart->products()->attach($product->id, ['quantity' => 2, 'total_price' => $product->price * 2]);
        // Realizar la petición para mostrar la página de checkout
        $response = $this->get(route('shopping_cart.checkout'));
        // Comprueba que la vista de checkout es devuelta con los datos correctos
        $response->assertStatus(200);
        $response->assertViewHas('shoppingCart', $cart);
    }

    /** @test */
    public function user_can_show_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear un producto y agregarlo al carrito de compras
        $product = Product::factory()->create(['stock' => 10]);
        $cart = ShoppingCart::create(['user_id' => $user->id]);
        $cart->products()->attach($product->id, ['quantity' => 2, 'total_price' => $product->price * 2]);
        // Realizar la petición para mostrar la página del carrito de compras
        $response = $this->get(route('shopping_cart'));
        // Comprueba que la vista del carrito de compras es devuelta con los datos correctos
        $response->assertStatus(200);
        $response->assertViewHas('shoppingCart', $cart);
    }

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // Crear un producto
        $product = Product::factory()->create(['stock' => 10]);
        // Realizar la petición para añadir el producto al carrito
        $response = $this->post(route('shopping_cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        // Comprueba que el usuario es redirigido a la página principal
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Producto añadido al carrito.');
        // Comprueba que el producto se ha añadido al carrito de compras
        $cart = ShoppingCart::where('user_id', $user->id)->first();
        $this->assertNotNull($cart);
        $this->assertEquals(2, $cart->products()->where('product_id', $product->id)->first()->pivot->quantity);
    }

    /** @test */
    public function user_can_update_product_quantity_in_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // Crear un producto y agregarlo al carrito de compras
        $product = Product::factory()->create(['stock' => 10]);
        $cart = ShoppingCart::create(['user_id' => $user->id]);
        $cart->products()->attach($product->id, ['quantity' => 2, 'total_price' => $product->price * 2]);
        // Realizar la petición para actualizar la cantidad del producto
        $response = $this->patch(route('cart.update', $product->id), [
            'quantity' => 3
        ]);
        // Comprueba que el usuario es redirigido a la página principal
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Cantidad del producto actualizada.');
        // Comprueba que la cantidad del producto se ha actualizado
        $cart = ShoppingCart::where('user_id', $user->id)->first();
        $this->assertEquals(3, $cart->products()->where('product_id', $product->id)->first()->pivot->quantity);
    }

    /** @test */
    public function user_can_remove_product_from_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // Crear un producto y agregarlo al carrito de compras
        $product = Product::factory()->create(['stock' => 10]);
        $cart = ShoppingCart::create(['user_id' => $user->id]);
        $cart->products()->attach($product->id, ['quantity' => 2, 'total_price' => $product->price * 2]);
        // Realizar la petición para eliminar el producto del carrito
        $response = $this->delete(route('cart.destroy', $product->id));
        // Comprueba que el usuario es redirigido a la página principal
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Producto eliminado del carrito.');
        // Comprueba que el producto se ha eliminado del carrito de compras
        $cart = ShoppingCart::where('user_id', $user->id)->first();
        $this->assertFalse($cart->products->contains($product));
    }
}
