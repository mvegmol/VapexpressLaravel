@extends('template.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-navbar mb-6">Mi Carrito de Compras</h1>

        @include('template.partials.alert')

        <div class="flex flex-col lg:flex-row">

            <div class="w-full lg:w-1/4 bg-gray-50 p-6 mb-10 lg:mb-0 lg:mr-6 rounded shadow-lg h-auto lg:h-fit">
                <h2 class="text-2xl font-semibold text-navbar mb-4">Resumen del Carrito</h2>
                <div class="text-gray-700 mb-4">
                    <p><strong>Productos Totales:</strong> {{ $shoppingCart->quantity }}</p>
                    <p><strong>Subtotal:</strong> {{ number_format($shoppingCart->total_price, 2) }}€</p>
                    @php
                        $shipping_cost = $shoppingCart->total_price < 50 ? 5 : 0;
                        $final_price = $shoppingCart->total_price + $shipping_cost;
                    @endphp
                    <p><strong>Coste de Envío:</strong>
                        {{ $shipping_cost > 0 ? number_format($shipping_cost, 2) . '€' : 'Gratis' }}
                    </p>
                    <p class="font-bold"><strong>Precio Total:</strong> {{ number_format($final_price, 2) }}€</p>
                </div>
                <a href="{{ route('shopping_cart.checkout') }}"
                    class="bg-navbar hover:bg-navbar text-white font-bold py-2 px-4 rounded block text-center shadow-md transition duration-300">
                    Tramitar pedido
                </a>
            </div>

            <div class="w-full lg:w-3/4">
                @if ($products->isEmpty())
                    <div class="bg-yellow-100 text-yellow-800 p-4 mb-4 rounded">
                        Tu carrito de compras está vacío.
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2">
                        @foreach ($products as $product)
                            <div class="flex bg-white shadow-md rounded-lg overflow-hidden">
                                <img src="{{ asset('img/productos/' . $product->url_image) }}" alt="{{ $product->name }}"
                                    class="w-24 h-24 object-cover flex-none">
                                <div class="flex flex-col justify-between p-4 leading-normal flex-grow">
                                    <div>
                                        <h3 class="text-lg font-semibold text-navbar">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-500">
                                            <strong>Categorías:</strong>
                                            @foreach ($product->categories as $category)
                                                <span>{{ $category->name }}</span>{{ !$loop->last ? ',' : '' }}
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm"><strong>Cantidad:</strong></p>
                                        <form action="{{ route('cart.update', $product->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="quantity" onchange="this.form.submit()"
                                                class="border rounded p-1">
                                                @for ($i = 1; $i <= $product->stock + $product->pivot->quantity; $i++)
                                                    <option value="{{ $i }}"
                                                        @if ($i == $product->pivot->quantity) selected @endif>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </form>
                                        <p class="text-sm mt-2"><strong>Precio por Unidad:</strong>
                                            {{ number_format($product->price, 2) }}€</p>
                                        <p class="text-sm"><strong>Total:</strong>
                                            {{ number_format($product->pivot->total_price, 2) }}€</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <form action="{{ route('cart.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" class="w-5 h-5 mr-4 mt-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 6h18M9 6v12M15 6v12M4 6h16v14H4V6zm3-3h10v3H7V3z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="w-full mt-4 flex justify-end ">
                        {{ $products->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
