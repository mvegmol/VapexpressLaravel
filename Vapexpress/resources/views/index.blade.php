@extends('template.app')

@section('carousel')
    @include('template.partials.carrusel')
@endsection

@section('content')
    @if (!auth()->check() && !request()->cookie('age_verified'))
        <div id="age-verification-modal"
            class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50 p-4 sm:p-8">
            <div
                class="bg-white rounded-lg shadow-xl p-6 sm:p-8 w-full max-w-xs sm:max-w-lg mx-auto text-center transform transition-all duration-300 ease-in-out scale-100">
                <h2 class="text-2xl sm:text-3xl font-extrabold mb-4 sm:mb-6 text-gray-900">Verificación de Edad</h2>

                <p class="mb-4 sm:mb-5 text-gray-600 text-base sm:text-lg">Para proteger a los menores y cumplir con las
                    regulaciones, debemos verificar que eres mayor de edad. No está permitida la venta a menores de 18 años.
                </p>
                <p class="mb-6 sm:mb-8 text-gray-700 text-xl sm:text-2xl font-bold">¿Tienes más de 18 años?</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                    <button id="age-yes"
                        class="bg-green-500 text-white px-6 sm:px-8 py-3 rounded-md shadow-lg hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transform transition duration-200 hover:-translate-y-1">Sí</button>
                    <button id="age-no"
                        class="bg-red-500 text-white px-6 sm:px-8 py-3 rounded-md shadow-lg hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transform transition duration-200 hover:-translate-y-1">No</button>
                </div>
            </div>
        </div>
    @endif



    <div class="container mx-auto px-4 py-8">

        <!-- Sección de productos más vendidos -->
        <section class="best-selling-products mb-12">
            <h1 class="text-3xl font-bold text-center mb-8 text-text_principal">Bienvenido a VAPEXPRESS</h1>
            @include('template.partials.alert')
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Productos Más Vendidos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($best_selling_products as $product)
                    <a href="{{ route('products.show_client', $product) }}">
                        <div
                            class="card bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                            <div class="relative h-48 sm:h-64 flex items-center justify-center bg-gradient-to-r ">
                                <img src="{{ asset('img/productos/' . $product->url_image) }}"
                                    alt="Imagen de {{ $product->name }}" class="w-full h-full object-contain">
                                <form action="{{ route('user.like') }}" method="POST" class="absolute top-2 left-2">
                                    @method('POST')
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
                            <div class="p-4 sm:p-6">
                                <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $product->name }}</h3>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700">{{ $product->price }}€</p>
                                    <form action="{{ route('shopping_cart.add') }}" method="POST">
                                        @method('POST')
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
            <!-- Botón para ver más productos -->
            <div class="flex justify-center mt-8 w-full">
                <a href="{{ route('products.search', ['order_by' => 'best_selling']) }}"
                    class="block w-full text-center bg-gradient-to-r from-navbar to-primary text-text_navbar py-3 px-8 text-lg font-bold rounded-lg shadow-lg hover:from-primary hover:to-navbar hover:shadow-xl transition duration-300 transform hover:scale-105 sm:max-w-lg">
                    Ver más productos
                </a>
            </div>
        </section>

        <!-- Sección de productos más nuevos -->
        <section class="new-products mb-12">
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Novedades</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($new_products as $product)
                    <a href="{{ route('products.show_client', $product) }}">
                        <div
                            class="card bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                            <div class="relative h-48 sm:h-64 flex items-center justify-center bg-gradient-to-r ">
                                <img src="{{ asset('img/productos/' . $product->url_image) }}"
                                    alt="Imagen de {{ $product->name }}" class="w-full h-full object-contain">
                                <form action="{{ route('user.like') }}" method="POST" class="absolute top-2 left-2">
                                    @method('POST')
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
                            <div class="p-4 sm:p-6">
                                <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $product->name }}</h3>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700">{{ $product->price }}€</p>
                                    <form action="{{ route('shopping_cart.add') }}" method="POST">
                                        @method('POST')
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
            <!-- Botón para ver más productos -->
            <div class="flex justify-center mt-8 w-full">
                <a href="{{ route('products.search', ['order_by' => 'newest']) }}"
                    class="block w-full text-center bg-gradient-to-r from-navbar to-primary text-text_navbar py-3 px-8 text-lg font-bold rounded-lg shadow-lg hover:from-primary hover:to-navbar hover:shadow-xl transition duration-300 transform hover:scale-105 sm:max-w-lg">
                    Ver más novedades
                </a>
            </div>
        </section>

        <!-- Sección de categorías destacadas -->
        <section class="featured-categories mb-12">
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Categorías Destacadas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                    <a href="{{ route('products.search', ['type' => 'Vaper Recargable']) }}">
                        <div class="relative h-48 flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/categorias/recargables.webp') }}" alt="Imagen de vapers recargables"
                                class="w-full h-full object-cover">
                        </div>
                    </a>
                </div>

                <div
                    class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                    <a href="{{ route('products.search', ['type' => 'Vaper Desechables']) }}">
                        <div class="relative h-48 flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/categorias/desechable.webp') }}" alt="Imagen de vapers desechables"
                                class="w-full h-full object-cover">
                        </div>
                    </a>
                </div>

                <div
                    class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                    <a href="{{ route('products.search', ['category' => 'E-líquidos']) }}">
                        <div class="relative h-48 flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/categorias/e-liquidos.webp') }}" alt="Imagen de E-Liquidos"
                                class="w-full h-full object-cover">
                        </div>
                    </a>
                </div>

                <div
                    class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                    <a href="{{ route('products.search', ['category' => 'Kits de Inicio']) }}">
                        <div class="relative h-48 flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/categorias/kit.webp') }}" alt="Imagen de Kit de vapeo"
                                class="w-full h-full object-cover">
                        </div>
                    </a>
                </div>
            </div>
        </section>

    </div>
@endsection
