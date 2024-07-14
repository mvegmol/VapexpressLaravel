@extends('template.app')

@section('content')
    <div class="container mx-auto">
        @include('template.partials.alert')
        <h1 class="text-3xl font-bold mb-6 text-black">Administración de Proveedores</h1>

        <form method="GET" action="{{ route('suppliers.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar proveedores..."
                class="border border-gray-300 p-2 rounded" />
            <button type="submit" class="bg-navbar text-white p-2 rounded">Buscar</button>

        </form>
        <div class="mb-4">
            <a href="{{ route('suppliers.create') }}" class="bg-navbar text-white p-2 rounded flex items-center w-max">
                <i class="fas fa-plus mr-1"></i> Crear Proveedor
            </a>
        </div>

        <div class="overflow-x-auto border rounded-md border-gray-350 ">
            <table class="min-w-full bg-white border border-gray-350 rounded-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th
                            class="w-1/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('suppliers.index', ['sort' => 'id', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">ID
                                <i class="fas fa-sort"></i></a>

                        </th>
                        <th
                            class="w-3/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('suppliers.index', ['sort' => 'name', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Nombre
                                del Proveedor<i class="fas fa-sort"></i></a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('suppliers.index', ['sort' => 'contact_name', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Nombre
                                de contacto<i class="fas fa-sort"></i></a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Número de Contacto
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('suppliers.index', ['sort' => 'email', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Correo
                                electrónico<i class="fas fa-sort"></i></a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $index => $supplier)
                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $supplier->id }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $supplier->name }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $supplier->contact_name }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $supplier->phone }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $supplier->email }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-center text-sm">
                                <div class="inline-flex items-center">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-xl">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-900 ml-2 text-xl">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $suppliers->appends(request()->input())->links('vendor.pagination.simple-tailwind') }}
    </div>
@endsection
