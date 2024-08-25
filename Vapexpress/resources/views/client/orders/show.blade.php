@extends('template.app')

@section('content')
    <div class="pt-4 pb-12 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <div class="flex justify-start items-start space-y-2 flex-col">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-semibold leading-7 md:leading-9 text-navbar">
                Pedido #{{ $order->id }}
            </h1>
            <p class="text-sm md:text-base font-medium leading-5 md:leading-6 text-gray-600">
                {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y \a \l\a\s h:i A') }}
            </p>
        </div>

        <div class="mt-8 md:mt-10 flex flex-col-reverse xl:flex-row justify-center items-stretch w-full xl:space-x-8">
            <!-- Sección de resumen y estado del pedido (1/3) -->
            <div class="flex flex-col w-full xl:w-1/3 space-y-4 md:space-y-6 xl:space-y-8 mt-8 xl:mt-0">
                <!-- Resumen -->
                <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 space-y-6">
                    <h3 class="text-lg md:text-xl font-semibold leading-5 text-navbar">
                        Resumen
                    </h3>
                    <div class="flex flex-col space-y-4 border-gray-200 border-b pb-4">
                        <div class="flex justify-between w-full">
                            <p class="text-base leading-4 text-navbar">Subtotal</p>
                            <p class="text-base leading-4 text-gray-600">
                                {{ number_format($order->products->sum(fn($product) => $product->price * $product->pivot->quantity), 2) }}€
                            </p>
                        </div>

                        <div class="flex justify-between items-center w-full">
                            <p class="text-base leading-4 text-navbar">Envío</p>
                            <p class="text-base leading-4 text-gray-600">
                                {{ $shipping_cost > 0 ? '5€' : 'Gratuito' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <p class="text-base font-semibold leading-4 text-navbar">Total</p>
                        <p class="text-base font-semibold leading-4 text-gray-600">
                            {{ number_format($order->total_price) }}€
                        </p>
                    </div>
                </div>

                <!-- Estado del pedido -->
                <div class="flex flex-col justify-center px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 space-y-6">
                    <h3 class="text-lg md:text-xl font-semibold leading-5 text-navbar">Estado del pedido</h3>
                    <div class="flex flex-col md:flex-row justify-between items-start w-full space-y-4 md:space-y-0">
                        <div class="flex justify-center items-center space-x-4">
                            <div class="w-8 h-8">
                                <img class="w-full h-full" alt="logo" src="https://i.ibb.co/L8KSdNQ/image-3.png" />
                            </div>
                            <div class="flex flex-col justify-start items-center">
                                <p class="text-sm md:text-lg leading-6 font-semibold text-navbar">
                                    UPS
                                    <br />
                                    <span class="font-normal text-xs md:text-base">Envío rápido y seguro 24/48h</span>
                                </p>
                            </div>
                        </div>
                        <p class="text-lg font-semibold leading-6 text-navbar">
                            {{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2) . '€' : 'Gratuito' }}
                        </p>
                    </div>
                    <div class="w-full grid gap-4 md:gap-8 grid-cols-1 md:grid-cols-2">
                        @php
                            $statusColor = match ($order->status) {
                                'pendiente' => 'bg-yellow-400 text-yellow-900',
                                'aceptado' => 'bg-blue-400 text-blue-900',
                                'en progreso' => 'bg-blue-400 text-blue-900',
                                'entregado' => 'bg-green-400 text-green-900',
                                'cancelado' => 'bg-red-400 text-red-900',
                                default => 'bg-gray-400 text-gray-900',
                            };
                        @endphp
                        <h4 class="text-left"> <span
                                class="relative inline-block px-3 py-1 font-semibold leading-tight rounded {{ $statusColor }}">
                                <span aria-hidden class="absolute inset-0 opacity-50 rounded-full"></span>
                                <span class="relative text-white">{{ ucfirst($order->status) }}</span>
                            </span></h4>
                        <a href="{{ $order->tracking_url }}" target="_blank" class="no-underline">
                            <button
                                class="hover:bg-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 py-2 w-full bg-navbar text-base font-medium leading-4 text-white rounded-lg">
                                Localizar Pedido
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sección de productos (2/3) -->
            <div class="flex flex-col justify-start items-start w-full xl:w-2/3 space-y-4 md:space-y-6 xl:space-y-8">
                <div class="flex flex-col justify-start items-start bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                    <p class="text-lg md:text-xl font-semibold leading-6 xl:leading-5 text-navbar">
                        Datos del Pedido
                    </p>

                    @foreach ($products as $product)
                        <div
                            class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                            <div class="pb-4 md:pb-8 w-full md:w-32 lg:w-40">
                                <img class="w-full md:w-full" src="{{ asset('img/productos/' . $product->url_image) }}"
                                    alt="{{ $product->name }}">
                            </div>
                            <div
                                class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                                <div class="w-full flex flex-col justify-start items-start space-y-4 md:space-y-8">
                                    <h3 class="text-lg md:text-xl xl:text-2xl font-semibold leading-6 text-navbar">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="flex justify-start items-start flex-col space-y-2">
                                        <!-- Mostrar todas las categorías -->
                                        <p class="text-sm leading-none text-navbar">
                                            Categorías:
                                            @foreach ($product->categories as $category)
                                                <span
                                                    class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs font-medium">{{ $category->name }}</span>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                                <div class="flex justify-between space-x-4 md:space-x-8 items-start w-full">
                                    <p class="text-base xl:text-lg leading-6 text-navbar">
                                        {{ $product->pivot->quantity }}
                                    </p>
                                    <p class="text-base xl:text-lg font-semibold leading-6 text-navbar">
                                        {{ number_format($product->price * $product->pivot->quantity, 2) }}€
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="w-full">{{ $products->links('vendor.pagination.tailwind') }}</div>
            </div>
        </div>
    </div>
@endsection
