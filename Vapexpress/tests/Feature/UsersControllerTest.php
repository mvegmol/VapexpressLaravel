<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Desactiva la verificación CSRF solo para pruebas
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /**
     * Probar el método profile para usuarios autenticados.
     */
    public function test_profile_method_authenticated()
    {
        // Crear un usuario
        $user = User::factory()->create();

        // Actuar como el usuario
        $this->actingAs($user);

        // Llamar al método profile
        $response = $this->get(route('user.profile'));

        // Verificar que se devuelve la vista de perfil con los datos correctos
        $response->assertStatus(200)
            ->assertViewIs('client.profile')
            ->assertViewHas('user_name', $user->name)
            ->assertViewHas('user_id', $user->id);
    }

    /**
     * Probar el método profile para usuarios no autenticados.
     */
    public function test_profile_method_unauthenticated()
    {
        // Llamar al método profile sin estar autenticado
        $response = $this->get(route('user.profile'));

        // Verificar que el usuario es redirigido a la página de inicio de sesión
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /**
     * Probar el método edit.
     */
    public function test_edit_method()
    {
        // Crear un usuario
        $user = User::factory()->create();

        // Actuar como el usuario
        $this->actingAs($user);

        // Llamar al método edit
        $response = $this->get(route('user.edit', $user->id));

        // Verificar que se devuelve la vista de actualización con los datos correctos
        $response->assertStatus(200)
            ->assertViewIs('client.update')
            ->assertViewHas('user', $user);
    }

    /**
     * Probar el método update.
     */
    public function test_update_method()
    {
        // Crear un usuario
        $user = User::factory()->create([
            'name' => 'Nombre Antiguo',
            'email' => 'antiguo@example.com',
        ]);

        // Actuar como el usuario
        $this->actingAs($user);

        // Preparar los datos para actualizar el usuario
        $data = [
            'name' => 'Nombre Nuevo',
            'email' => 'nuevo@example.com',
        ];

        // Llamar al método update
        $response = $this->put(route('user.update', $user->id), $data);

        // Verificar que el usuario fue actualizado
        $response->assertRedirect(route('user.profile'))
            ->assertSessionHas('success', 'Tu perfil ha sido actualizado');

        // Verificar que los datos del usuario en la base de datos están actualizados
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nombre Nuevo',
            'email' => 'nuevo@example.com',
        ]);
    }

    /**
     * Probar el método like_unlike.
     */
    public function test_like_unlike_method()
    {
        // Crear un usuario y un producto
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // Actuar como el usuario
        $this->actingAs($user);

        // Dar like al producto
        $response = $this->post(route('user.like'), ['product_id' => $product->id]);
        $response->assertRedirect(URL::previous());

        // Verificar que el producto fue marcado como favorito
        $user = $user->fresh(); // Recargar el usuario desde la base de datos
        $this->assertTrue($user->favouriteProducts->contains($product));

        // Quitar el like al producto
        $response = $this->post(route('user.like'), ['product_id' => $product->id]);
        $response->assertRedirect(URL::previous());

        // Verificar que el producto fue removido de los favoritos
        $user = $user->fresh(); // Recargar el usuario desde la base de datos
        $this->assertFalse($user->favouriteProducts->contains($product));
    }
}
