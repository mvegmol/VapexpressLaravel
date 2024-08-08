@extends('template.app')

@section('content')
    <div class="container mx-16 px-4 py-8">
        <h1 class="text-3xl font-bold text-navbar mb-6">Tramitar Pedido</h1>

        @include('template.partials.alert')

        <div class="flex flex-col lg:flex-row">
            <!-- Información del Pedido a la Izquierda -->
            <div class="w-full lg:w-2/3 lg:mr-6">
                <form id="orderForm" method="POST" action="{{ route('stripe.checkout') }}">
                    @method('POST')
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h2 class="text-2xl font-semibold text-navbar mb-4">Dirección de Envío</h2>
                    <div class="space-y-4 mb-4">
                        <a href="{{ route('addresses.create') }}" class="text-blue-500 hover:text-navbar">
                            + Agregar nueva dirección
                        </a>
                        @foreach ($addresses as $index => $address)
                            <div class="flex items-start border p-4 rounded mb-2 address-item mt-2"
                                @if ($index >= 2) style="display: none;" @endif>
                                <input type="radio" name="address" value="{{ $address->id }}"
                                    @if ($address->is_default) checked @endif class="address-radio mt-1 mr-3">
                                <div>
                                    <strong>{{ $address->full_name }}</strong><br>
                                    {{ $address->direction }}, {{ $address->city }}, {{ $address->province }}<br>
                                    Código Postal: <span>{{ $address->zip_code }}</span><br>
                                    Número de contacto: <span>{{ $address->contact_phone }}</span>
                                </div>
                            </div>
                        @endforeach
                        @if ($addresses->count() > 2)
                            <button id="toggleAddress" type="button" class="text-blue-500 hover:text-navbar mt-2">
                                Ver más direcciones
                            </button>
                        @endif
                    </div>

                    <h2 class="text-2xl font-semibold text-navbar mb-4">Detalles del Pedido</h2>
                    <ul>
                        @foreach ($shoppingCart->products as $product)
                            <li class="flex items-center border-b p-4">
                                <img src="{{ asset('img/productos/' . $product->url_image) }}" alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover mr-4">
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    <p class="text-sm text-gray-500">Cantidad: {{ $product->pivot->quantity }}</p>
                                    <p class="text-sm text-gray-500">Precio:
                                        {{ number_format($product->pivot->total_price, 2) }}€</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </form>
            </div>

            <!-- Resumen del Pedido a la Derecha -->
            <div class="w-full lg:w-1/3 bg-gray-50 p-6 rounded shadow-lg h-auto lg:h-fit">
                <h2 class="text-2xl font-semibold text-navbar mb-4">Resumen del Pedido</h2>
                <div class="text-gray-700 mb-4">
                    <p class="mb-2"><strong>Productos Totales:</strong> {{ $shoppingCart->quantity }}</p>
                    <p class="mb-2"><strong>Subtotal:</strong> {{ number_format($shoppingCart->total_price, 2) }}€</p>
                    @php
                        $shipping_cost = $shoppingCart->total_price < 50 ? 5 : 0;
                        $final_price = $shoppingCart->total_price + $shipping_cost;
                    @endphp
                    <p class="mb-2"><strong>Coste de Envío:</strong>
                        {{ $shipping_cost == 0 ? 'Gratis' : '€' . number_format($shipping_cost, 2) }} </p>
                    <p class="font-bold mb-2"><strong>Precio Total:</strong> {{ number_format($final_price, 2) }}€</p>
                </div>
                <div class="flex justify-center">
                    <button type="submit" form="orderForm"
                        class="bg-navbar hover:bg-navbar text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                        Confirmar Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleAddress').addEventListener('click', function() {
            const addressItems = document.querySelectorAll('.address-item');
            addressItems.forEach((item, index) => {
                if (index >= 2) {
                    if (item.style.display === 'none') {
                        item.style.display = 'block';
                        this.textContent = 'Ver menos direcciones';
                    } else {
                        item.style.display = 'none';
                        this.textContent = 'Ver más direcciones';
                    }
                }
            });
        });

        // Escuchar el evento de cambio en los inputs de tipo radio para actualizar la dirección predeterminada
        document.querySelectorAll('.address-radio').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const selectedAddressId = this.value;

                    fetch(`/addresses/changue/${selectedAddressId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Dirección predeterminada actualizada correctamente');
                            } else {
                                console.error('Error al actualizar la dirección predeterminada');
                            }
                        })
                        .catch(error => {
                            console.error('Error en la solicitud AJAX:', error);
                        });
                }
            });
        });
    </script>
@endsection
