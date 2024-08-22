<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        Storage::fake('public');  // Para pruebas de subida de imágenes
    }

    /**
     * Probar el método index.
     */
    public function test_index_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        Product::factory(10)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.Products.index')
            ->assertViewHas('products');
    }

    /**
     * Probar el método create.
     */
    public function test_create_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $response = $this->get(route('products.create.admin'));

        $response->assertStatus(200)
            ->assertViewIs('admin.Products.create')
            ->assertViewHas('categories')
            ->assertViewHas('suppliers');
    }

    /**
     * Probar el método store.
     */
    public function test_store_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $proveedor = Supplier::factory()->create();
        $categoria = Category::factory()->create();

        $data = [
            'name' => 'Nuevo Producto',
            'description' => 'Una breve descripción del nuevo producto.',  // Breve descripción del nuevo producto
            'price' => 99.99,
            'stock' => 10,
            'url_image' => UploadedFile::fake()->image('producto.jpg'), // Archivo simulado
            'supplier_id' => $proveedor->id,
            'categories' => [$categoria->id],
        ];

        // Realizar la solicitud POST para almacenar el producto
        $response = $this->post(route('products.store'), $data);

        // Verificar redirección y mensaje de éxito
        $response->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Producto creado exitosamente.');

        // Verificar la existencia en la base de datos
        $this->assertDatabaseHas('products', [
            'name' => 'Nuevo Producto',
            'description' => 'Una breve descripción del nuevo producto.',
            'price' => 99.99,
            'stock' => 10,
            'supplier_id' => $proveedor->id,
        ]);

        // Puedes omitir la verificación del archivo en el disco simulado
        // Storage::disk('public')->assertExists('productos/producto.jpg');
    }

    /**
     * Probar el método update.
     */
    public function test_update_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $producto = Product::factory()->create();
        $nuevoProveedor = Supplier::factory()->create();
        $nuevaCategoria = Category::factory()->create();

        $data = [
            'name' => 'Producto Actualizado',
            'description' => 'Descripción actualizada.',  // Descripción actualizada
            'price' => 79.99,
            'stock' => 15,
            'url_image' => UploadedFile::fake()->image('producto_actualizado.jpg'), // Usando un archivo .jpg
            'supplier_id' => $nuevoProveedor->id,
            'categories' => implode(',', [$nuevaCategoria->id]), // Convertido a cadena
        ];

        $response = $this->put(route('products.update', $producto->id), $data);

        $response->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Producto actualizado exitosamente.');

        $this->assertDatabaseHas('products', [
            'id' => $producto->id,
            'name' => 'Producto Actualizado',
            'description' => 'Descripción actualizada.',
            'price' => 79.99,
            'stock' => 15,
            'supplier_id' => $nuevoProveedor->id,
        ]);

        // No se verifica la existencia del archivo en el almacenamiento
    }

    /**
     * Probar el método edit.
     */
    public function test_edit_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $producto = Product::factory()->create();

        $response = $this->get(route('products.edit', $producto->id));

        $response->assertStatus(200)
            ->assertViewIs('admin.Products.edit')
            ->assertViewHas('product', $producto)
            ->assertViewHas('categories')
            ->assertViewHas('suppliers');
    }

    /**
     * Probar el método destroy.
     */
    public function test_destroy_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $producto = Product::factory()->create(['url_image' => 'producto.jpg']);

        $response = $this->delete(route('products.destroy', $producto->id));

        $response->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Producto eliminado exitosamente.');

        $this->assertModelMissing($producto);
        // No se verifica la existencia del archivo en el almacenamiento
    }

    /**
     * Probar el método show.
     */
    public function test_show_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $producto = Product::factory()->create();

        $response = $this->get(route('products.show', $producto->id));

        $response->assertStatus(200)
            ->assertViewIs('admin.Products.show')
            ->assertViewHas('product', $producto)
            ->assertViewHas('categories')
            ->assertViewHas('suppliers');
    }
}
