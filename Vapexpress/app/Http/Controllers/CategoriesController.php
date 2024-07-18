<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //comprobamos si hay una búsqueda
        $query = $request->input('search');
        //comprobamos si se va ordenar por algún campo
        $sortField = $request->input('sort', 'name');
        //comprobamos si la dirección para ordenar es ascendente o descendente
        $sortDirection = $request->input('direction', 'asc');

        $categories = Category::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%{$query}%")
                ->orWhere('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);

        if ($categories->isEmpty()) {
            return redirect()->route("categories.index")
                ->with("error", "No se han encontrado resultados de la consulta realizada: $query");
        }

        return view("admin.Categories.index", compact("categories", "query", "sortField", "sortDirection"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.Categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'required|string|max:400',
        ]);

        try {
            DB::beginTransaction();

            $category = new Category();
            $category->name = $validatedData['name'];
            $category->description = $validatedData['description'];
            $category->save();
            DB::commit();
            return redirect()->route('categories.index')
                ->with('success', 'La categoría se ha creado correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('categories.create')
                ->with('error', 'Ocurrió un error al crear la categoría: ' . $e->getMessage())
                ->withInput();
        }
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
        try {
            $category = Category::findOrFail($id);
            return view('admin.Categories.edit', compact('category'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al editar la categoría: ', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id,
            'description' => 'required|string|max:400',
        ]);

        try {
            DB::beginTransaction();
            $category->name = $validatedData['name'];
            $category->description = $validatedData['description'];
            $category->save();

            DB::commit();

            return redirect()->route('categories.index')
                ->with('success', 'La categoría ha sido actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('categories.edit', $category->id)
                ->with('error', 'Ocurrió un error al actualizar la categoría: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();
            $category->delete();
            DB::commit();
            return redirect()->route('categories.index')
                ->with('success', 'La categoría ha sido eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categories.index')
                ->with('error', 'Ocurrió un error al eliminar la categoría: ' . $e->getMessage());
        }
    }

    /**
     * Show the products of the specified category.
     */
    public function products(Category $category)
    {
        // Obtiene los productos que ya están en la categoría
        $existingProductIds = $category->products()->pluck('product_id')->toArray();

        // Filtra los productos que no están en la categoría
        $all_products = Product::whereNotIn('id', $existingProductIds)->get();

        // Obtiene los productos paginados de la categoría
        $products = $category->products()->paginate(12);
        return view('admin.Categories.products', compact('category', 'products', 'all_products'));
    }


    /**
     * Store a newly created product in the specified category.
     */
    public function storeProduct(Request $request, Category $category)
    {
        $category->products()->attach($request->input('product_id'));

        return redirect()->route('categories.products', $category->id)
            ->with('success', 'Producto añadido a la categoría correctamente');
    }


    /**
     * Remove the specified product from the specified category.
     */
    public function destroyProduct(Category $category, Product $product)
    {
        $category->products()->detach($product->id);

        return redirect()->route('categories.products', $category->id)
            ->with('success', 'Producto eliminado de la categoría correctamente');
    }
}
