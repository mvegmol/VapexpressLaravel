<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Desactiva la verificación CSRF 
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /**
     * Probar el método index con y sin consultas de búsqueda.
     */
    public function test_index_method()
    {
        // Crea un usuario administrador
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        Category::factory(10)->create();

        // Llama al método index
        $response = $this->get(route('categories.index'));
        // Comprueba que la vista de index es devuelta con los datos correctos
        $response->assertStatus(200)
            ->assertViewIs('admin.Categories.index')
            ->assertViewHas('categories');
    }

    /**
     * Probar el método create.
     */
    public function test_create_method()
    {
        // Crea un usuario administrador
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Llama al método create
        $response = $this->get(route('categories.create'));
        // Comprueba que la vista de create es devuelta
        $response->assertStatus(200)
            ->assertViewIs('admin.Categories.create');
    }

    /**
     * Probar el método store.
     */
    public function test_store_method()
    {
        // Crea un usuario administrador
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Datos de la nueva categoría
        $data = [
            'name' => 'Nueva Categoría',
            'description' => 'Una breve descripción de la nueva categoría.',
        ];
        // Llama al método store
        $response = $this->post(route('categories.store'), $data);
        // Comprueba que la categoría se ha creado correctamente
        $response->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'La categoría se ha creado correctamente.');
        // Comprueba que la categoría se ha añadido a la base de datos
        $this->assertDatabaseHas('categories', [
            'name' => 'Nueva Categoría',
            'description' => 'Una breve descripción de la nueva categoría.',
        ]);
    }

    /**
     * Probar el método edit.
     */
    public function test_edit_method()
    {
        // Crea un usuario administrador
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Crea una categoría
        $category = Category::factory()->create();
        // Llama al método edit
        $response = $this->get(route('categories.edit', $category->id));
        // Comprueba que la vista de edit es devuelta con los datos correctos
        $response->assertStatus(200)
            ->assertViewIs('admin.Categories.edit')
            ->assertViewHas('category', $category);
    }

    /**
     * Probar el método update.
     */
    public function test_update_method()
    {
        // Crea un usuario administrador
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Crea una categoría
        $category = Category::factory()->create();
        // Datos actualizados de la categoría
        $data = [
            'name' => 'Categoría Actualizada',
            'description' => 'Descripción actualizada de la categoría.',
        ];
        // Llama al método update
        $response = $this->put(route('categories.update', $category->id), $data);
        // Comprueba que la categoría se ha actualizado correctamente
        $response->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'La categoría ha sido actualizada correctamente.');
        // Comprueba que la categoría se ha actualizado en la base de datos
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Categoría Actualizada',
            'description' => 'Descripción actualizada de la categoría.',
        ]);
    }

    /**
     * Probar el método destroy.
     */
    public function test_destroy_method()
    {
        // Crea un usuario administrador
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Crea una categoría
        $category = Category::factory()->create();
        // Llama al método destroy
        $response = $this->delete(route('categories.destroy', $category->id));
        // Comprueba que la categoría se ha eliminado correctamente
        $response->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'La categoría ha sido eliminada correctamente.');
        // Comprueba que la categoría se ha eliminado de la base de datos
        $this->assertModelMissing($category);
    }

    /**
     * Probar el método products.
     */
    public function test_products_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Crea una categoría y un producto
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $category->products()->attach($product->id);
        // Llama al método products
        $response = $this->get(route('categories.products', $category->id));
        // Comprueba que la vista de products es devuelta con los datos correctos
        $response->assertStatus(200)
            ->assertViewIs('admin.Categories.products')
            ->assertViewHas('category', $category)
            ->assertViewHas('products')
            ->assertViewHas('all_products');
    }

    /**
     * Probar el método storeProduct.
     */
    public function test_store_product_method()
    {
        // Crea un usuario administrador
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Crea una categoría y un producto
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        // Llama al método storeProduct
        $response = $this->post(route('categories.products.store', $category->id), [
            'product_id' => $product->id
        ]);
        // Comprueba que el producto se ha añadido a la categoría correctamente
        $response->assertRedirect(route('categories.products', $category->id))
            ->assertSessionHas('success', 'Producto añadido a la categoría correctamente');
        // Comprueba que el producto se ha añadido a la base de datos
        $this->assertTrue($category->products()->where('product_id', $product->id)->exists());
    }

    /**
     * Probar el método destroyProduct.
     */
    public function test_destroy_product_method()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        // Crea una categoría y un producto
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $category->products()->attach($product->id);
        // Llama al método destroyProduct
        $response = $this->delete(route('categories.products.destroy', ['category' => $category->id, 'product' => $product->id]));
        // Comprueba que el producto se ha eliminado de la categoría correctamente
        $response->assertRedirect(route('categories.products', $category->id))
            ->assertSessionHas('success', 'Producto eliminado de la categoría correctamente');
        // Comprueba que el producto se ha eliminado de la base de datos
        $this->assertFalse($category->products()->where('product_id', $product->id)->exists());
    }
}
