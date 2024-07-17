@extends('template.app')

@section('content')
    @include('template.partials.alert')
    <div class="container mx-auto p-6">
        <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg">
            <div class="bg-navbar text-white p-6 flex justify-between items-center rounded-t-lg">
                <h1 class="text-3xl font-bold">Detalles del Producto</h1>
                <div class="flex">
                    <a href="{{ route('products.index') }}"
                        class="bg-white text-navbar py-2 px-4 rounded-lg flex items-center mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                    <a href="{{ route('products.edit', $product->id) }}"
                        class="bg-white text-navbar py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6 ">
                <!-- Información del producto y proveedor -->
                <div class="lg:col-span-3">
                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 py-2">Nombre del Producto</label>
                        <p class="text-lg">{{ $product->name }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 py-2">Descripción</label>
                        <p class="text-lg">{{ $product->description }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 py-2">Precio</label>
                        <p class="text-lg">{{ $product->price }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 py-2">Stock</label>
                        <p class="text-lg">{{ $product->stock }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 py-2">Proveedor</label>
                        <p class="text-lg">{{ $product->supplier->name }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 py-2">Categorías</label>
                        @foreach ($product->categories as $category)
                            <span
                                class="inline-block bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-sm font-medium">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Imagen del producto -->
                <div class="lg:col-span-2 ">
                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 py-2">Imagen del Producto</label>
                        @if ($product->url_image)
                            <img src="{{ asset('img/productos/' . $product->url_image) }}" alt="Imagen del Producto"
                                class="w-64 h-64 object object-center">
                        @else
                            <p class="text-lg">No hay imagen disponible</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
