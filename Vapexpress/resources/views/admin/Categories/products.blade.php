@extends('template.app')

@section('content')
    <div class="container mx-auto">
        <div class="mb-4">
            <a href="{{ route('categories.index') }}" class="bg-navbar text-white p-2 rounded inline-flex items-center">
                <i class="fas fa-arrow-left mr-1"></i> Volver a Categorías
            </a>
        </div>

        <h1 class="text-3xl font-bold mb-6 text-black">Productos de la Categoría: {{ $category->name }}</h1>

        <div class="mb-4">
            <form action="{{ route('categories.products.store', $category->id) }}" method="POST">
                @csrf
                <select name="product_id" class="border border-gray-300 p-2 rounded" required>
                    @foreach ($all_products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-navbar text-white p-2 rounded">Añadir Producto</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($products as $product)
                <div class="bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg flex flex-col">
                    <div class="flex justify-center p-4">
                        <img src="{{ asset('img/productos/' . $product->url_image) }}" alt="{{ $product->name }}"
                            class="w-24 h-24 object-contain">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">{{ $product->name }}</h2>
                            <p class="text-gray-600 text-sm">{{ $product->description }}</p>
                        </div>
                        <div class="mt-2 flex justify-between items-center">
                            <p class="text-gray-800 font-semibold text-sm">Precio: ${{ $product->price }}</p>
                            <p class="text-gray-800 font-semibold text-sm">Stock: {{ $product->stock }}</p>
                        </div>
                        <div class="flex justify-end mt-4">
                            <form action="{{ route('categories.products.destroy', [$category->id, $product->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-900 text-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
@endsection
