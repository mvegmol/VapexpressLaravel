@extends('template.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6 text-navbar">Mis Pedidos</h1>

        <!-- Filtro por estado -->
        <form action="{{ route('order.index') }}" method="GET" class="mb-4">
            <div class="flex items-center">
                <label for="status" class="mr-2 text-base font-medium">Filtrar por estado:</label>
                <select name="status" id="status"
                    class="form-select block w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    onchange="this.form.submit()">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aceptado" {{ request('status') == 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                    <option value="en progreso" {{ request('status') == 'en progreso' ? 'selected' : '' }}>En progreso
                    </option>
                    <option value="entregado" {{ request('status') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
        </form>

        <!-- Tabla de pedidos -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden text-base">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 bg-gray-100 border-b  border-gray-200 text-gray-800 text-left text-base uppercase font-bold">
                            Pedido</th>
                        <th
                            class="px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-base uppercase font-bold">
                            Fecha del pedido</th>
                        <th
                            class="px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-base uppercase font-bold">
                            Total</th>
                        <th
                            class="px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-base uppercase font-bold">
                            Estado</th>
                        <th
                            class="px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-base uppercase font-bold'">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-100">
                            <td class="px-5 py-5 border-b border-gray-200 text-base">
                                <p class="text-gray-900 whitespace-no-wrap">#{{ $order->id }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 text-base">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $order->order_date }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 text-base">
                                <p class="text-gray-900 whitespace-no-wrap">{{ number_format($order->total_price, 2) }}€</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 text-base ">
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
                                <span
                                    class="relative inline-block px-3 text-black py-1 font-semibold leading-tight rounded {{ $statusColor }}">
                                    <span aria-hidden class="absolute inset-0 opacity-50 rounded-full"></span>
                                    <span class="relative text-black">{{ ucfirst($order->status) }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 text-base">
                                <a href="{{ route('order.show', $order->id) }}" class="text-blue-600 hover:text-navbar">Ver
                                    Detalles</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 border-b border-gray-200 text-center text-base">Todavía no
                                has realizado ningún pedido.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4 flex justify-end">
            {{ $orders->appends(['status' => request('status')])->links('vendor.pagination.tailwind') }}
        </div>

    </div>
@endsection
