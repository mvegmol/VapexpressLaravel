@extends('template.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @include('template.partials.alert')
        <h1 class="text-3xl font-bold mb-6 text-black">Administración de Productos</h1>

        <form method="GET" action="{{ route('products.index') }}"
            class="mb-4 flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar productos..."
                class="border border-gray-300 p-2 rounded w-full sm:w-auto" />
            <select name="category" class="border border-gray-300 p-2 rounded w-full sm:w-auto">
                <option value="">Todas las categorías</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $categoryFilter ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-navbar text-white p-2 rounded w-full sm:w-auto">Buscar</button>
        </form>

        <div class="mb-4">
            <a href="{{ route('products.create.admin') }}"
                class="bg-navbar text-white p-2 rounded flex items-center w-full sm:w-max">
                <i class="fas fa-plus mr-1"></i> Crear Producto
            </a>
        </div>

        <div class="overflow-x-auto border rounded-md border-gray-350">
            <table class="min-w-full bg-white border border-gray-350 rounded-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th
                            class="w-1/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('products.index', ['sort' => 'id', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'category' => $categoryFilter]) }}">
                                ID <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th
                            class="w-3/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('products.index', ['sort' => 'name', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'category' => $categoryFilter]) }}">
                                Nombre del Producto <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('products.index', ['sort' => 'price', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'category' => $categoryFilter]) }}">
                                Precio <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            <a
                                href="{{ route('products.index', ['sort' => 'stock', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'category' => $categoryFilter]) }}">
                                Stock <i class="fas fa-sort"></i>
                            </a>
                        </th>
                        <th
                            class="w-3/12 px-4 py-2 border-b border-gray-350 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Categorías
                        </th>
                        <th
                            class="w-2/12 px-4 py-2 border-b border-gray-350 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-100' }}">
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->id }}
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->name }}
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->price }}
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->stock }}
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-sm text-gray-900">
                                @foreach ($product->categories->take(2) as $category)
                                    <span
                                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                                @if ($product->categories->count() > 2)
                                    <span
                                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                        y {{ $product->categories->count() - 2 }} más
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b border-gray-300 whitespace-nowrap text-center text-sm">
                                <div class="inline-flex items-center justify-center space-x-2">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="text-green-600 hover:text-green-900 text-xl">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-xl">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-900 text-xl">
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

        <div class="mt-4">
            {{ $products->appends(request()->input())->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
@endsection
