<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

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
        // Obtener todas las categorías para poder asignarle una categoria a un producto y los proveedores 
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view("admin.Products.create", compact("categories", 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'url_image' => 'nullable|image|mimes:png|max:2048',
            'supplier_id' => 'required|exists:suppliers,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        DB::beginTransaction();

        try {
            // Crear el producto
            $product = new Product();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');

            // Manejar la carga de la imagen
            if ($request->hasFile('url_image')) {
                $image = $request->file('url_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img/productos'), $imageName);
                $product->url_image = $imageName; // Guardar solo el nombre del archivo
            }

            $product->supplier_id = $request->input('supplier_id');
            $product->save();

            // Asignar las categorías al producto
            $product->categories()->sync($request->input('categories', []));

            DB::commit();

            // Redirigir a la página de índice de productos con un mensaje de éxito
            return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirigir a la página de creación de productos con un mensaje de error
            return redirect()->route('products.create')->with('error', 'Hubo un error al crear el producto. Por favor, inténtelo de nuevo.');
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
