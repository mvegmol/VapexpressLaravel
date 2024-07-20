@extends('template.app')

@section('content')
    <div class="container mx-auto">
        @include('template.partials.alert')
        <h1 class="text-3xl font-bold mb-6 text-black">Administración de Pedidos</h1>

        <form method="GET" action="{{ route('orders.admin.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar pedidos..."
                class="border border-gray-300 p-2 rounded" />
            <button type="submit" class="bg-navbar text-white p-2 rounded">Buscar</button>
        </form>

        <div class="overflow-x-auto border rounded-md border-gray-350">
            <table class="min-w-full bg-white border border-gray-350 rounded-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th
                            class="w-1/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('orders.admin.index', ['sort' => 'id', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                ID <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Fecha del Pedido
                        </th>
                        <th
                            class="w-1/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Cantidad de Productos
                        </th>

                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('orders.admin.index', ['sort' => 'total_price', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                Precio Total <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Estado Actual
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                            <td
                                class="px-4 py-2 border-b text-center border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->id }}</td>
                            <td
                                class="px-4 py-2 border-b text-center border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->user->name }}</td>
                            <td
                                class="px-4 py-2 border-b text-center border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->order_date }}</td>
                            <td
                                class="px-4 py-2 border-b text-center border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->products->sum('pivot.quantity') }}</td>
                            <td
                                class="px-4 py-2 border-b text-center border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->total_price }}
                            </td>
                            <td
                                class="px-4 py-2 text-center border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                        class="border border-gray-300 p-2 rounded">
                                        @foreach (['pending', 'accepted', 'in progress', 'delivered', 'cancelled'] as $status)
                                            <option value="{{ $status }}"
                                                {{ $order->status == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-2 border-b  border-gray-300 whitespace-nowrap text-center text-sm">
                                <div class="inline-flex items-center">
                                    <a href="{{ route('orders.admin.show', $order) }}"
                                        class="text-blue-600 hover:text-blue-900 text-xl"><i class="fas fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $orders->appends(request()->input())->links('vendor.pagination.simple-tailwind') }}
    </div>
@endsection
