@extends('template.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <section class="new-products mb-12">
            <h2 class="text-2xl font-bold mb-6 text-text_principal">Novedades</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                @foreach ($products as $product)
                    <a href="{{ route('products.show_client', $product) }}">
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
                    </a>
                @endforeach
            </div>
            <!-- Botón para ver más productos -->
            <div class="flex justify-end mt-8">
                {{ $products->appends(request()->input())->links('vendor.pagination.tailwind') }}
            </div>
        </section>
    </div>
@endsection
