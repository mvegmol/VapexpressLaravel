<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuppliersControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /**
     * Probar el método index con y sin consultas de búsqueda.
     */
    public function test_index_method()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        // Crear 10 proveedores
        Supplier::factory(10)->create();
        // Llamar al método index
        $response = $this->get(route('suppliers.index'));
        // Comprobar que la vista de index es devuelta con los datos correctos
        $response->assertStatus(200)
            ->assertViewIs('admin.suppliers.index')
            ->assertViewHas('suppliers');
    }

    /**
     * Probar el método create.
     */
    public function test_create_method()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        // Llamar al método create
        $response = $this->get(route('suppliers.create'));
        $response->assertStatus(200)
            ->assertViewIs('admin.suppliers.create');
    }

    /**
     * Probar el método store.
     */
    public function test_store_method()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        // Datos del proveedor
        $data = [
            'name' => 'Nuevo Proveedor',
            'contact_name' => 'Juan Pérez',
            'phone' => '123456789',
            'email' => 'proveedor@example.com',
        ];
        // Llamar al método store
        $response = $this->post(route('suppliers.store'), $data);
        // Verificar que se redirige correctamente
        $response->assertRedirect(route('suppliers.index'))
            ->assertSessionHas('success', 'El proveedor ha sido creado correctamente.');
        // Verificar que el proveedor se ha creado en la base de datos
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Nuevo Proveedor',
            'contact_name' => 'Juan Pérez',
            'phone' => '123456789',
            'email' => 'proveedor@example.com',
        ]);
    }

    /**
     * Probar el método edit.
     */
    public function test_edit_method()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        // Crear un proveedor
        $supplier = Supplier::factory()->create();
        // Llamar al método edit
        $response = $this->get(route('suppliers.edit', $supplier->id));
        //  Verificar que la vista de edición es devuelta con los datos correctos
        $response->assertStatus(200)
            ->assertViewIs('admin.suppliers.edit')
            ->assertViewHas('supplier', $supplier);
    }

    /**
     * Probar el método update.
     */
    public function test_update_method()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        // Crear un proveedor
        $supplier = Supplier::factory()->create();
        // Datos del proveedor actualizado
        $data = [
            'name' => 'Proveedor Actualizado',
            'contact_name' => 'Ana López',
            'phone' => '987654321',
            'email' => 'actualizado@example.com',
        ];
        // Llamar al método update
        $response = $this->put(route('suppliers.update', $supplier->id), $data);
        // Verificar que se redirige correctamente
        $response->assertRedirect(route('suppliers.index'))
            ->assertSessionHas('success', 'El proveedor ha sido actualizado correctamente.');
        // Verificar que el proveedor se ha actualizado en la base de datos
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'name' => 'Proveedor Actualizado',
            'contact_name' => 'Ana López',
            'phone' => '987654321',
            'email' => 'actualizado@example.com',
        ]);
    }

    /**
     * Probar el método destroy.
     */
    public function test_destroy_method()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        // Crear un proveedor
        $supplier = Supplier::factory()->create();
        // Llamar al método destroy
        $response = $this->delete(route('suppliers.destroy', $supplier->id));
        // Verificar que se redirige correctamente
        $response->assertRedirect(route('suppliers.index'))
            ->assertSessionHas('success', 'Proveedor eliminado correctamente.');
        // Verificar que el proveedor se ha eliminado de la base de datos
        $this->assertModelMissing($supplier);
    }
}
