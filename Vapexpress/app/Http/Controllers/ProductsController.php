<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartProduct;

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
            'url_image' => 'nullable|image|mimes:jpg|max:2048',
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
    public function show(Product  $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view("admin.Products.show", compact("product", "categories", 'suppliers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view("admin.Products.edit", compact("product", "categories", 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'url_image' => 'nullable|image|mimes:png|max:2048',
            'supplier_id' => 'required|exists:suppliers,id',
            'categories' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar los datos del producto
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->supplier_id = $request->input('supplier_id');

            // Manejar la carga de la imagen si se ha subido una nueva imagen
            if ($request->hasFile('url_image')) {
                // Eliminar la imagen anterior si existe
                if ($product->url_image) {
                    Storage::delete('img/productos/' . $product->url_image);
                }

                $image = $request->file('url_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img/productos'), $imageName);
                $product->url_image = $imageName; // Guardar solo el nombre del archivo
            }

            // Guardar los cambios
            $product->save();

            // Asignar las categorías al producto
            $categories = explode(',', $request->input('categories'));
            $product->categories()->sync($categories);

            DB::commit();

            // Redirigir a la página de índice de productos con un mensaje de éxito
            return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Redirigir a la página de edición de productos con un mensaje de error
            return redirect()->route('products.edit', $product)->with('error', 'Hubo un error al actualizar el producto. Por favor, inténtelo de nuevo.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {


        try {
            DB::beginTransaction();
            // Eliminar la imagen asociada si existe
            if ($product->url_image) {
                Storage::delete('img/productos/' . $product->url_image);
            }
            // Eliminar las relaciones con las categorías
            $product->categories()->detach();
            // Eliminar el producto
            $product->delete();

            DB::commit();

            // Redirigir a la página de índice de productos con un mensaje de éxito
            return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirigir a la página de índice de productos con un mensaje de error
            return redirect()->route('products.index')->with('error', 'Hubo un error al eliminar el producto. Por favor, inténtelo de nuevo.');
        }
    }


    public function home()
    {
        # Productos más novedosos
        $new_products = Product::orderBy('created_at', 'desc')->take(10)->get();
        # Productos más vendidos
        $best_selling_products = Product::bestSellings()->take(10)->get();
        # Categorías más populares
        $categories = Category::inRandomOrder()->take(6)->get();

        # Productos favoritos si el usuario está autenticado
        $favourite_products = auth()->check() ? auth()->user()->favouriteProducts->pluck('id')->toArray() : [];

        return view('index', compact('new_products', 'best_selling_products', 'categories', 'favourite_products'));
    }


    public function favourites_products()
    {
        try {
            //Comprobamos si el usuario está autenticado y logado
            if (!auth()->check()) {
                return redirect()->route('login');
            }
            DB::beginTransaction();

            $client = auth()->user();

            $products = $client->favouriteProducts()->paginate(10);

            $favourite_products = auth()->check() ? auth()->user()->favouriteProducts->pluck('id')->toArray() : [];

            DB::commit();

            return view('client.favourites', compact('products', 'favourite_products'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('home')->with('error', 'Error al mostrar los productos favoritos.');
        }
    }

    public function show_client(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        // Obtener los productos favoritos del usuario autenticado
        $favourite_products = auth()->check() ? auth()->user()->favouriteProducts->pluck('id')->toArray() : [];

        return view("client.product", compact("product", "categories", 'suppliers', 'favourite_products'));
    }

    public function client_index(Request $request)
    {

        return view("Products.index");
    }


    public function search(Request $request)
    {
        try {
            DB::beginTransaction();

            // Obtenemos los parámetros de búsqueda y filtros
            $query = $request->input('search');
            $typeFilter = $request->input('type');
            $brandFilter = $request->input('brand');
            $categoryFilter = $request->input('category');
            $orderBy = $request->input('order_by', 'name_asc');

            // Realizamos la consulta de productos
            $products = Product::when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('id', 'like', "%{$query}%");
            })
                ->when($typeFilter, function ($queryBuilder) use ($typeFilter) {
                    return $queryBuilder->whereHas('categories', function ($query) use ($typeFilter) {
                        $query->where('categories.name', $typeFilter);
                    });
                })
                ->when($brandFilter, function ($queryBuilder) use ($brandFilter) {
                    return $queryBuilder->where('supplier_id', $brandFilter);
                })
                ->when($categoryFilter, function ($queryBuilder) use ($categoryFilter) {
                    return $queryBuilder->whereHas('categories', function ($query) use ($categoryFilter) {
                        $query->where('categories.name', $categoryFilter);
                    });
                });

            // Aplicar el ordenamiento según la opción seleccionada
            switch ($orderBy) {
                case 'price_asc':
                    $products = $products->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $products = $products->orderBy('price', 'desc');
                    break;
                case 'name_desc':
                    $products = $products->orderBy('name', 'desc');
                    break;
                case 'newest':
                    $products = $products->orderBy('created_at', 'desc');
                    break;
                case 'best_selling':
                    $products = Product::bestSellings(); // Usar el método bestSellings
                    break;
                case 'name_asc':
                default:
                    $products = $products->orderBy('name', 'asc');
                    break;
            }

            $products = $products->with(['categories', 'supplier'])->paginate(15);

            if ($products->isEmpty()) {
                DB::rollBack();
                return redirect()->route("products.search")
                    ->with("error", "No se han encontrado resultados para los filtros seleccionados.");
            }

            $suppliers = Supplier::all();
            DB::commit();

            $favourite_products = auth()->check() ? auth()->user()->favouriteProducts->pluck('id')->toArray() : [];

            return view("Products.index", compact("products", "query", "typeFilter", "brandFilter", "categoryFilter", "orderBy", "suppliers", "favourite_products"));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('home')->with('error', 'Error en la búsqueda de productos.');
        }
    }


    public function home_admin()
    {
        // Total de usuarios registrados
        $totalUsers = User::count();

        // Usuarios registrados en los últimos 30 días
        $userRegistrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Pedidos realizados en los últimos 30 días
        $orderData = Order::select(DB::raw('DATE(order_date) as date'), DB::raw('count(*) as count'))
            ->where('order_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Productos más vendidos
        $bestSellingProducts = Product::bestSellings()->take(10)->get();

        // Proveedores más comprados
        $topSuppliers = Supplier::select('suppliers.name', DB::raw('SUM(order_product.quantity) as total_quantity'))
            ->join('products', 'suppliers.id', '=', 'products.supplier_id')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->groupBy('suppliers.id', 'suppliers.name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // Preparar datos para las gráficas
        $userRegistrationDates = $userRegistrations->pluck('date');
        $userRegistrationCounts = $userRegistrations->pluck('count');

        $orderDates = $orderData->pluck('date');
        $orderCounts = $orderData->pluck('count');

        $bestSellingProductNames = $bestSellingProducts->pluck('name');
        $bestSellingProductQuantities = $bestSellingProducts->pluck('total_orders');

        $supplierNames = $topSuppliers->pluck('name');
        $supplierQuantities = $topSuppliers->pluck('total_quantity');

        return view('index_admin', compact(
            'totalUsers',
            'userRegistrationDates',
            'userRegistrationCounts',
            'orderDates',
            'orderCounts',
            'bestSellingProductNames',
            'bestSellingProductQuantities',
            'supplierNames',
            'supplierQuantities'
        ));
    }
}
