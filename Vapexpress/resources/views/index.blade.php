@extends('template.app')

@section('carousel')
    @include('template.partials.carrusel')
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Sección de productos más vendidos -->
        <section class="best-selling-products mb-12">
            <h1 class="text-3xl font-bold text-center mb-8 text-text_principal">Bienvenido a VAPEXPRESS</h1>
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Productos Más Vendidos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                @foreach ($best_selling_products as $product)
                    <div
                        class="card bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                        <div class="relative h-64 flex items-center justify-center bg-gradient-to-r ">
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
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-700">{{ $product->price }}€</p>
                                <form action="{{ route('shopping_cart.add') }}" method="POST">
                                    @method('POST')
                                    @csrf
                                    {{-- Enviamos el id del producto --}}
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit">
                                        <i
                                            class="btn-cart fas fa-shopping-cart text-navbar cursor-pointer transition duration-300 ease-in-out transform hover:scale-125"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Botón para ver más productos -->
            <div class="flex justify-center mt-8">
                <a href="{{ route('products.index') }}"
                    class="block text-center w-full bg-gradient-to-r from-navbar to-primary text-text_navbar py-3 text-lg font-bold rounded-lg shadow-lg hover:from-primary hover:to-navbar hover:shadow-xl transition duration-300 transform hover:scale-105">Ver
                    más productos</a>
            </div>
        </section>

        <!-- Sección de productos más nuevos-->
        <section class="new-products mb-12">
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Novedades</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                @foreach ($new_products as $product)
                    <div
                        class="card bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                        <div class="relative h-64 flex items-center justify-center bg-gradient-to-r ">
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
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-700">{{ $product->price }}€</p>
                                <form action="{{ route('shopping_cart.add') }}" method="POST">
                                    @method('POST')
                                    @csrf
                                    {{-- Enviamos el id del producto --}}
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit">
                                        <i
                                            class="btn-cart fas fa-shopping-cart text-navbar cursor-pointer transition duration-300 ease-in-out transform hover:scale-125"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Botón para ver más productos -->
            <div class="flex justify-center mt-8">
                <a href="{{ route('products.index') }}"
                    class="block text-center w-full bg-gradient-to-r from-navbar to-primary text-text_navbar py-3 text-lg font-bold rounded-lg shadow-lg hover:from-primary hover:to-navbar hover:shadow-xl transition duration-300 transform hover:scale-105">Ver
                    más novedades</a>
            </div>
        </section>

        <!-- Sección de categorías destacadas -->
        <section class="featured-categories mb-12">
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Categorías Destacadas</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- First large image -->
                <div class="col-span-1 lg:col-span-3">
                    <div
                        class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                        <div class="relative  flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/categorias/petizius.jpg') }}" alt="Imagen de de vaper sabor petizui"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Two smaller images in the center -->
                <div class="col-span-1 lg:col-span-3 flex">
                    <div
                        class="w-1/2 bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105 mr-4">
                        <div class="relative  flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/categorias/recargables.webp') }}" alt="Imagen de vapers recargables"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div
                        class="w-1/2 bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105 ml-4">
                        <div class="relative  flex items-center justify-center bg-gradient-to-r  ">
                            <img src="{{ asset('img/categorias/desechable.webp') }}" alt="Imagen de vapers desechables"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Second large image -->
                <div class="col-span-1 lg:col-span-3 flex">
                    <div
                        class="w-1/2 bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105 mr-4">
                        <div class="relative  flex items-center justify-center bg-gradient-to-r ">
                            <img src="{{ asset('img/categorias/e-liquidos.webp') }}" alt="Imagen de E-Liquidos"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div
                        class="w-1/2 bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105 ml-4">
                        <div class="relative  flex items-center justify-center bg-gradient-to-r  ">
                            <img src="{{ asset('img/categorias/kit.webp') }}" alt="Imagen de Kit de vapeo"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
