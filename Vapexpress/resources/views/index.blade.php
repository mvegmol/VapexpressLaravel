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
                            <button
                                class="btn-heart absolute top-2 left-2 text-gray-500 hover:text-primary transition duration-300 ease-in-out transform hover:scale-125 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <i class="far fa-heart"></i>
                                <span class="sr-only">Agregar a favoritos</span>
                            </button>
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-700">${{ $product->price }}</p>
                                <i
                                    class="btn-cart fas fa-shopping-cart text-navbar cursor-pointer transition duration-300 ease-in-out transform hover:scale-125"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Botón para ver más productos -->
            <div class="flex justify-center mt-8">
                <a href="{{ route('products.index') }}"
                    class="block text-center w-full bg-gradient-to-r from-navbar to-primary text-text_navbar py-3 text-lg font-bold rounded-lg hover:from-navbar hover:to-primary transition duration-300">Ver
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
                            <button
                                class="btn-heart absolute top-2 left-2 text-gray-500 hover:text-primary transition duration-300 ease-in-out transform hover:scale-125 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                <i class="far fa-heart"></i>
                                <span class="sr-only">Agregar a favoritos</span>
                            </button>
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-gray-700">${{ $product->price }}</p>
                                <i
                                    class="btn-cart fas fa-shopping-cart text-navbar cursor-pointer transition duration-300 ease-in-out transform hover:scale-125"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Botón para ver más productos -->
            <div class="flex justify-center mt-8">
                <a href="{{ route('products.index') }}"
                    class="block text-center w-full bg-gradient-to-r from-navbar to-primary text-text_navbar py-3 text-lg font-bold rounded-lg hover:from-navbar hover:to-primary transition duration-300">Ver
                    más novedades</a>
            </div>
        </section>

        <!-- Sección de categorías destacadas -->
        <section class="featured-categories">
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Categorías Destacadas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                @foreach ($categories as $category)
                    <div
                        class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold mb-2 text-text_principal">{{ $category->name }}</h3>
                            {{-- <a href="{{ route('category.show', $category->id) }}"
                                class="bg-navbar text-text_a px-3 py-2 rounded mt-4 inline-block hover:bg-navbar focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Ver
                                Categoría</a> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
