@extends('template.app')

@section('content')
    <div class="container mx-auto p-4 md:p-6">
        <h1 class="text-xl md:text-2xl font-semibold mb-4 md:mb-6 text-navbar">Mis Pedidos</h1>

        <!-- Filtro por estado -->
        <form action="{{ route('order.index') }}" method="GET" class="mb-4">
            <div class="flex flex-col md:flex-row items-start md:items-center">
                <label for="status" class="mb-2 md:mb-0 md:mr-2 text-sm md:text-base font-medium">Filtrar por
                    estado:</label>
                <select name="status" id="status"
                    class="form-select block w-full md:w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
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
        <div class="bg-white shadow-md rounded-lg overflow-hidden text-sm md:text-base">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-2 md:px-5 py-3 bg-gray-100 border-b  border-gray-200 text-gray-800 text-left text-xs md:text-base uppercase font-bold">
                                Pedido</th>
                            <th
                                class="px-2 md:px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-xs md:text-base uppercase font-bold">
                                Fecha del pedido</th>
                            <th
                                class="px-2 md:px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-xs md:text-base uppercase font-bold">
                                Total</th>
                            <th
                                class="px-2 md:px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-xs md:text-base uppercase font-bold">
                                Estado</th>
                            <th
                                class="px-2 md:px-5 py-3 bg-gray-100 border-b border-gray-200 text-gray-800 text-left text-xs md:text-base uppercase font-bold'">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-100">
                                <td class="px-2 md:px-5 py-5 border-b border-gray-200 text-xs md:text-base">
                                    <p class="text-gray-900 whitespace-no-wrap">#{{ $order->id }}</p>
                                </td>
                                <td class="px-2 md:px-5 py-5 border-b border-gray-200 text-xs md:text-base">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y \a \l\a\s h:i A') }}</p>
                                </td>
                                <td class="px-2 md:px-5 py-5 border-b border-gray-200 text-xs md:text-base">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ number_format($order->total_price, 2) }}€
                                    </p>
                                </td>
                                <td class="px-2 md:px-5 py-5 border-b border-gray-200 text-xs md:text-base">
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
                                        class="relative inline-block px-2 md:px-3 py-1 text-xs md:text-base font-semibold leading-tight rounded {{ $statusColor }}">
                                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full"></span>
                                        <span class="relative">{{ ucfirst($order->status) }}</span>
                                    </span>
                                </td>
                                <td class="px-2 md:px-5 py-5 border-b border-gray-200 text-xs md:text-base">
                                    <a href="{{ route('order.show', $order->id) }}"
                                        class="text-blue-600 hover:text-navbar">Ver
                                        Detalles</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-2 md:px-5 py-5 border-b border-gray-200 text-center text-xs md:text-base">
                                    Todavía no
                                    has realizado ningún pedido.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div class="w-full mt-4 flex justify-end md:justify-end">
            {{ $orders->appends(['status' => request('status')])->links('vendor.pagination.tailwind') }}
        </div>

    </div>
@endsection
