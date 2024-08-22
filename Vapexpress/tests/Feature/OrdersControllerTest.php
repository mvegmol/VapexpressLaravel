<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOrderConfirmationMail;

class OrdersControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario admin y un usuario regular
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create();

        // Deshabilitar CSRF para pruebas
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function an_authenticated_user_can_place_an_order()
    {
        // Crear un producto y agregarlo al carrito de compras
        $producto = Product::factory()->create();
        $cantidad = 2;
        $subtotal = $producto->price * $cantidad;
        $costoEnvio = $subtotal < 50 ? 5 : 0;
        $precioTotal = $subtotal + $costoEnvio;

        $carritoCompras = ShoppingCart::create(['user_id' => $this->user->id]);
        $carritoCompras->products()->attach($producto->id, ['quantity' => $cantidad, 'total_price' => $producto->price]);

        // Actuar como el usuario
        $this->actingAs($this->user);

        // Crear una dirección y guardarla en la sesión
        $direccion = Address::factory()->create();
        session(['selected_address_id' => $direccion->id]);

        // Simular el envío de correo electrónico
        Mail::fake();

        // Realizar la petición para guardar el pedido
        $response = $this->post(route('order.store'));

        // Asegurar la redirección a la página principal
        $response->assertRedirect(route('home'));

        // Verificar mensaje de éxito
        $response->assertSessionHas('success', 'Pedido realizado correctamente.');

        // Verificar que el pedido se guardó correctamente en la base de datos
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            //'total_price' => number_format($precioTotal, 2, '.', ''), // Asegurar que el formato del precio coincida
            'status' => 'pending', // Asegurar que el estado coincida
        ]);

        // Verificar que se envió el correo de confirmación
        Mail::assertSent(SendOrderConfirmationMail::class);
    }

    /** @test */
    public function an_admin_can_view_all_orders()
    {
        // Crear un pedido
        $pedido = Order::factory()->create();

        // Actuar como admin
        $this->actingAs($this->admin);

        // Realizar la petición para ver todos los pedidos
        $response = $this->get(route('orders.admin.index'));

        // Verificar el estado de la respuesta
        $response->assertStatus(200);
        $response->assertSee($pedido->id);
    }

    /** @test */
    public function an_admin_can_view_a_specific_order()
    {
        // Crear un pedido
        $pedido = Order::factory()->create();

        // Actuar como admin
        $this->actingAs($this->admin);

        // Realizar la petición para ver un pedido específico
        $response = $this->get(route('orders.admin.show', $pedido->id));

        // Verificar el estado de la respuesta
        $response->assertStatus(200);
        $response->assertSee($pedido->id);
    }

    /** @test */
    public function an_admin_can_update_order_status()
    {
        // Crear un pedido con el estado 'pending'
        $pedido = Order::factory()->create(['status' => 'pending']);

        // Actuar como admin
        $this->actingAs($this->admin);

        // Actualizar el estado del pedido
        $response = $this->put(route('orders.updateStatus', $pedido->id), ['status' => 'accepted']);

        // Verificar que se redirige correctamente
        $response->assertRedirect(route('orders.admin.index'));
        $response->assertSessionHas('success', 'Estado del pedido actualizado correctamente');

        // Verificar que el estado del pedido se ha actualizado en la base de datos
        $this->assertDatabaseHas('orders', [
            'id' => $pedido->id,
            'status' => 'accepted',
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_view_their_orders()
    {
        // Crear un pedido para el usuario autenticado
        $pedido = Order::factory()->create(['user_id' => $this->user->id]);

        // Actuar como el usuario
        $this->actingAs($this->user);

        // Realizar la petición para ver los pedidos del usuario
        $response = $this->get(route('order.index'));

        // Verificar el estado de la respuesta
        $response->assertStatus(200);
        $response->assertSee($pedido->id);
    }
}
