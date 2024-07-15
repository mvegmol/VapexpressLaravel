<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Comprobamos si hay una búsqueda
        $query = $request->input('search');
        // Comprobamos si se va ordenar por algún campo
        $sortField = $request->input('sort', 'name');
        // Comprobamos si la dirección para ordenar es ascendente o descendente
        $sortDirection = $request->input('direction', 'asc');
        // Filtro por categoría
        $categoryFilter = $request->input('category');

        $products = Product::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%{$query}%")
                ->orWhere('id', 'like', "%{$query}%"); // Si hay una búsqueda, filtrar por nombre o id
        })
            ->when($categoryFilter, function ($queryBuilder) use ($categoryFilter) {
                return $queryBuilder->whereHas('categories', function ($query) use ($categoryFilter) {
                    $query->where('categories.id', $categoryFilter);
                });
            })
            ->with('categories') // Cargar las categorías con cada producto
            ->orderBy($sortField, $sortDirection) // Ordenar por el campo y dirección indicados
            ->paginate(10);

        if ($products->isEmpty()) {
            return redirect()->route("products.index")
                ->with("error", "No se han encontrado resultados de la consulta realizada: $query");
        }

        // Obtener todas las categorías para el filtro
        $categories = Category::all();

        return view("admin.Products.index", compact("products", "query", "sortField", "sortDirection", "categories", "categoryFilter"));
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
