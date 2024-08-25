@extends('template.app')

@section('content')
    <div class="container mx-auto my-8 px-4">
        <div
            class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden border-gradient-to-r from-blue-500 to-green-500">
            <div class="md:flex">
                <!-- Imagen del producto -->
                <div class="w-full md:w-1/2 h-64 md:h-auto relative bg-gray-100">
                    <img src="{{ asset('img/productos/' . $product->url_image) }}" alt="Imagen de {{ $product->name }}"
                        class="w-full h-full object-contain p-4 transition-transform duration-300 hover:scale-105 rounded-lg">
                    <div class="absolute top-2 right-2 bg-white rounded-full p-2 shadow-lg">
                        <form action="{{ route('user.like') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit"
                                class="text-2xl text-gray-500 hover:text-red-700 transition duration-300 ease-in-out transform hover:scale-125 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                @if (auth()->check() && in_array($product->id, $favourite_products))
                                    <i class="fas fa-heart"></i>
                                @else
                                    <i class="far fa-heart"></i>
                                @endif
                                <span class="sr-only">Agregar a favoritos</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Detalles del producto -->
                <div class="w-full md:w-1/2 p-6 flex flex-col justify-between">
                    <!-- Título del producto -->
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-navbar mb-4">{{ $product->name }}</h1>
                        <p class="text-gray-700 mb-4 leading-relaxed">{{ $product->description }}</p>

                        <!-- Categorías -->
                        <div class="mb-4">
                            <span class="font-semibold text-gray-800">Categorías: </span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach ($product->categories as $category)
                                    <span
                                        class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs md:text-sm hover:bg-navbar hover:text-white transition">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Proveedor -->
                        <div class="mb-4">
                            <span class="font-semibold text-gray-800">Proveedor: </span>
                            <span class="text-gray-700">{{ $product->supplier->name }}</span>
                        </div>

                        <!-- Stock y Precio -->
                        <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                            <div class="mb-2 md:mb-0">
                                <span class="font-semibold text-gray-800">Stock: </span>
                                <span class="text-gray-700">{{ $product->stock }}</span>
                            </div>
                            <div class="text-2xl md:text-3xl font-bold">{{ $product->price }}€</div>
                        </div>
                    </div>

                    <!-- Acciones: Cantidad, Like y Añadir al carrito -->
                    <div class="flex flex-col md:flex-row items-center justify-between mt-4">
                        <!-- Campo de cantidad con botones -->
                        <form action="{{ route('shopping_cart.add') }}" method="POST"
                            class="flex items-center mb-4 md:mb-0 w-full md:w-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="flex items-center border rounded overflow-hidden w-full md:w-24">
                                <button type="button" class="bg-gray-300 px-3 py-1" onclick="decreaseQuantity()">-</button>
                                <input type="text" name="quantity" id="quantity" value="1"
                                    class="text-center w-full outline-none border-none" readonly>
                                <button type="button" class="bg-gray-300 px-3 py-1" onclick="increaseQuantity()">+</button>
                            </div>
                            <button type="submit"
                                class="bg-navbar hover:bg-hover text-white font-bold py-2 px-6 rounded ml-4 w-full md:w-auto mt-4 md:mt-0 transition">
                                Añadir al carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function increaseQuantity() {
            var quantity = document.getElementById('quantity');
            var max = {{ $product->stock }};
            var currentValue = parseInt(quantity.value);
            if (currentValue < max) {
                quantity.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            var quantity = document.getElementById('quantity');
            var currentValue = parseInt(quantity.value);
            if (currentValue > 1) {
                quantity.value = currentValue - 1;
            }
        }
    </script>
@endsection
