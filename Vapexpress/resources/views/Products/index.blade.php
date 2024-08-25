@extends('template.app')

@section('content')
    <div class="container mx-auto px-4 mt-6">
        {{-- alertas --}}
        @include('template.partials.alert')

        <!-- Filtros -->
        <h2 class="text-2xl font-bold mb-4">Filtros:</h2>
        <div class="flex flex-wrap mb-6 space-y-4 sm:space-y-0">
            <form id="filtersForm" action="{{ route('products.search') }}" method="GET"
                class="w-full flex flex-wrap space-x-0 sm:space-x-4">
                <div class="w-full sm:flex-1 mb-4 sm:mb-0">
                    <select name="type" class="w-full border rounded-md p-2"
                        onchange="document.getElementById('filtersForm').submit();">
                        <option value="">Todos los tipos</option>
                        <option value="Vaper Recargable" {{ $typeFilter == 'Vaper Recargable' ? 'selected' : '' }}>Vapers
                            Recargable
                        </option>
                        <option value="Vaper Desechables" {{ $typeFilter == 'Vaper Desechables' ? 'selected' : '' }}>Vapers
                            Desechable
                        </option>
                    </select>
                </div>
                <div class="w-full sm:flex-1 mb-4 sm:mb-0">
                    <select name="brand" class="w-full border rounded-md p-2"
                        onchange="document.getElementById('filtersForm').submit();">
                        <option value="">Todas las marcas</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $brandFilter == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:flex-1 mb-4 sm:mb-0">
                    <select name="category" class="w-full border rounded-md p-2"
                        onchange="document.getElementById('filtersForm').submit();">
                        <option value="">Todas las categorías</option>
                        <option value="E-líquidos" {{ $categoryFilter == 'E-líquidos' ? 'selected' : '' }}>Líquido</option>
                        <option value="Vaper" {{ $categoryFilter == 'Vaper' ? 'selected' : '' }}>Vapers</option>
                        <option value="Accesorios" {{ $categoryFilter == 'Accesorios' ? 'selected' : '' }}>Accesorios
                        </option>
                        <option value="Kits de Inicio" {{ $categoryFilter == 'Kits de Inicio' ? 'selected' : '' }}>Kits de
                            Inicio
                        </option>
                    </select>
                </div>
                <div class="w-full sm:flex-1 mb-4 sm:mb-0">
                    <select name="order_by" class="w-full border rounded-md p-2"
                        onchange="document.getElementById('filtersForm').submit();">
                        <option value="name_asc" {{ $orderBy == 'name_asc' ? 'selected' : '' }}>Nombre: A-Z</option>
                        <option value="name_desc" {{ $orderBy == 'name_desc' ? 'selected' : '' }}>Nombre: Z-A</option>
                        <option value="price_asc" {{ $orderBy == 'price_asc' ? 'selected' : '' }}>Precio: Más bajo a más
                            alto</option>
                        <option value="price_desc" {{ $orderBy == 'price_desc' ? 'selected' : '' }}>Precio: Más alto a más
                            bajo</option>
                        <option value="newest" {{ $orderBy == 'newest' ? 'selected' : '' }}>Novedades</option>
                        <option value="best_selling" {{ $orderBy == 'best_selling' ? 'selected' : '' }}>Más vendidos
                        </option>
                    </select>
                </div>
            </form>
        </div>
        <br>
        <!-- Lista de Productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach ($products as $product)
                <a href="{{ route('products.show_client', $product) }}">
                    <div
                        class="card bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                        <div class="relative h-64 flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/productos/' . $product->url_image) }}"
                                alt="Imagen de {{ $product->name }}" class="w-full h-full object-contain">
                            <form action="{{ route('user.like') }}" method="POST" class="absolute top-2 left-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit"
                                    class="text-2xl btn-heart text-gray-500 hover:text-red-700 transition duration-300 ease-in-out transform hover:scale-125 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                                    @if (!auth()->check()) onclick="event.preventDefault(); window.location='{{ route('login') }}';" @endif>
                                    @if (auth()->check() && in_array($product->id, $favourite_products))
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="far fa-heart"></i>
                                    @endif
                                    <span class="sr-only">Agregar a favoritos</span>
                                </button>
                            </form>
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-700">{{ $product->price }}€</p>
                                <form action="{{ route('shopping_cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit">
                                        <i
                                            class="btn-cart fas fa-shopping-cart text-navbar cursor-pointer transition duration-300 ease-in-out transform hover:scale-125"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-6 ">
            {{ $products->links() }}
        </div>
    </div>
@endsection
