@extends('template.app')

@section('content')
    <div class="container mx-auto">
        @include('template.partials.alert')
        <h1 class="text-3xl font-bold mb-6 text-black">Administración de las Categorías</h1>

        <form method="GET" action="{{ route('categories.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categorías..."
                class="border border-gray-300 p-2 rounded" />
            <button type="submit" class="bg-navbar text-white p-2 rounded">Buscar</button>
        </form>
        <div class="mb-4">
            <a href="{{ route('categories.create') }}" class="bg-navbar text-white p-2 rounded flex items-center w-max">
                <i class="fas fa-plus mr-1"></i> Crear categoría
            </a>
        </div>

        <div class="overflow-x-auto border rounded-md border-gray-350 ">
            <table class="min-w-full bg-white border border-gray-350 rounded-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th
                            class="w-1/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('categories.index', ['sort' => 'id', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">ID
                                <i class="fas fa-sort"></i></a>
                        </th>
                        <th
                            class="w-3/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('categories.index', ['sort' => 'name', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">Nombre
                                de la Categoría<i class="fas fa-sort"></i></a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a>Descripción</a>
                        </th>
                        <th
                            class="w-1/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a>Productos</a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $category->id }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $category->name }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $category->description }}</td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-center text-sm">
                                <a href="{{ route('categories.products', $category->id) }}"
                                    class="text-blue-600 hover:text-blue-900 text-xl">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-center text-sm">
                                <div class="inline-flex items-center">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-xl">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST">
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

        {{ $categories->appends(request()->input())->links('vendor.pagination.simple-tailwind') }}
    </div>
@endsection
