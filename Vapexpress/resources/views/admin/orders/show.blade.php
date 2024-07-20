@extends('template.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-black">Detalle del Pedido #{{ $order->id }}</h1>
            <a href="{{ route('orders.admin.index') }}" class="bg-navbar text-white p-2 rounded"><i
                    class="fas fa-arrow-left mr-1"></i>Volver </a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex flex-col md:flex-row">
                <!-- Información del Pedido -->
                <div class="w-full md:w-2/3 pr-4">
                    <h2 class="text-2xl font-semibold mb-4">Información del Pedido</h2>
                    <p><strong>Fecha del Pedido:</strong> {{ $order->order_date }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Precio Total:</strong> ${{ $order->total_price }}</p>
                    <p><strong>Dirección:</strong> {{ $order->address }}</p>
                </div>

                <!-- Información del Cliente -->
                <div class="w-full md:w-1/3 pl-4">
                    <h2 class="text-2xl font-semibold mb-4">Información del Cliente</h2>
                    <p><strong>Nombre:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mt-6 mb-4">Productos</h2>
            <div class="flex flex-wrap -mx-2">
                @foreach ($order->products as $product)
                    <div class="w-full md:w-1/2 lg:w-1/3 px-2 mb-4">
                        <div class="bg-white border rounded-lg shadow-md overflow-hidden p-2 flex">
                            <img src="{{ asset('img/productos/' . $product->url_image) }}" alt="{{ $product->name }}"
                                class="w-48 h-48 object-cover object-center">
                            <div class="p-4">
                                <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-700 mb-2"><strong>Cantidad:</strong> {{ $product->pivot->quantity }}
                                </p>
                                <p class="text-gray-700 mb-2"><strong>Precio:</strong> ${{ $product->pivot->price }}</p>
                                <p class="text-gray-700 mb-2">
                                    <strong>Categorías:</strong>
                                    <br>
                                    @foreach ($product->categories as $category)
                                        <span
                                            class="inline-block mt-2 bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $category->name }}</span>
                                    @endforeach
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>


    </div>
@endsection
