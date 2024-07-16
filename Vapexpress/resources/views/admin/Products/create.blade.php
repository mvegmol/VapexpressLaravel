@extends('template.app')

@section('content')
    @include('template.partials.alert')
    <div class="container mx-auto p-6">
        <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg">
            <div class="bg-navbar text-white p-6 flex justify-between items-center rounded-t-lg">
                <h1 class="text-3xl font-bold">Crear Producto</h1>
                <a href="{{ route('products.index') }}" class="bg-white text-navbar py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Información del producto y proveedor -->
                        <div class="lg:col-span-1">
                            <div class="mb-4">
                                <label for="name" class="block text-base font-medium text-gray-700 py-2">Nombre del
                                    Producto</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="border border-gray-300 p-2 rounded w-full @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                    class="block text-base font-medium text-gray-700 py-2">Descripción</label>
                                <textarea name="description" id="description" rows="4"
                                    class="border border-gray-300 p-2 rounded w-full @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-base font-medium text-gray-700 py-2">Precio</label>
                                <input type="text" name="price" id="price" value="{{ old('price') }}"
                                    class="border border-gray-300 p-2 rounded w-full @error('price') border-red-500 @enderror">
                                @error('price')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="stock" class="block text-base font-medium text-gray-700 py-2">Stock</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                                    class="border border-gray-300 p-2 rounded w-full @error('stock') border-red-500 @enderror">
                                @error('stock')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="url_image" class="block text-base font-medium text-gray-700 py-2">Imagen del
                                    Producto</label>
                                <div class="custom-file-input-container">
                                    <input type="file" name="url_image" id="url_image"
                                        class="border border-gray-300 p-2 rounded w-full @error('url_image') border-red-500 @enderror">
                                    @error('url_image')
                                        <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Selector de categorías -->
                        <div class="lg:col-span-2">
                            <div class="mb-4">
                                <label for="supplier_id"
                                    class="block text-base font-medium text-gray-700 py-2">Proveedor</label>
                                <select name="supplier_id" id="supplier_id"
                                    class="border border-gray-300 p-2 rounded w-full">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="block text-base font-medium text-gray-700 py-2">Categorías</label>
                            <div class="flex space-x-4">
                                <div class="w-1/3">
                                    <h2 class="text-base font-medium text-gray-700 mb-2">Categorías Disponibles:</h2>
                                    <select id="availableCategories" class="border border-gray-300 p-2 rounded w-full"
                                        multiple size="10">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center space-y-2 w-1/3">
                                    <button type="button" id="addCategory"
                                        class="bg-navbar text-white py-2 px-8 rounded w-full">Añadir -></button>
                                    <button type="button" id="removeCategory"
                                        class="bg-navbar text-white py-2 px-8 rounded w-full"><- Eliminar</button>
                                            <button type="button" id="addAllCategories"
                                                class="bg-navbar text-white py-2 px-8 rounded w-full">Añadir todos</button>
                                            <button type="button" id="removeAllCategories"
                                                class="bg-navbar text-white py-2 px-8 rounded w-full">Eliminar
                                                Todos</button>
                                </div>
                                <div class="w-1/3">
                                    <h2 class="text-base font-medium text-gray-700 mb-2">Categorías Seleccionadas:</h2>
                                    <select id="selectedCategories" name="categories[]"
                                        class="border border-gray-300 p-2 rounded w-full" multiple size="10">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" class="bg-navbar text-white px-6 py-3 rounded-lg">Crear Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .custom-file-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .custom-file-input-container input[type="file"] {
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .custom-file-input-container input[type="file"]::before {
            content: 'Examinar...';
            display: inline-block;
            padding: 0.5rem 1rem;
            color: white;
            background-color: gray;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 1rem;
        }

        .custom-file-input-container input[type="file"]::-webkit-file-upload-button {
            visibility: hidden;
        }
    </style>
    <script>
        document.getElementById('addCategory').onclick = function() {
            var availableCategories = document.getElementById('availableCategories');
            var selectedCategories = document.getElementById('selectedCategories');
            while (availableCategories.selectedOptions.length > 0) {
                var option = availableCategories.selectedOptions[0];
                selectedCategories.appendChild(option);
            }
        };

        document.getElementById('removeCategory').onclick = function() {
            var selectedCategories = document.getElementById('selectedCategories');
            var availableCategories = document.getElementById('availableCategories');
            while (selectedCategories.selectedOptions.length > 0) {
                var option = selectedCategories.selectedOptions[0];
                availableCategories.appendChild(option);
            }
        };

        document.getElementById('addAllCategories').onclick = function() {
            var availableCategories = document.getElementById('availableCategories');
            var selectedCategories = document.getElementById('selectedCategories');
            while (availableCategories.options.length > 0) {
                var option = availableCategories.options[0];
                selectedCategories.appendChild(option);
            }
        };

        document.getElementById('removeAllCategories').onclick = function() {
            var selectedCategories = document.getElementById('selectedCategories');
            var availableCategories = document.getElementById('availableCategories');
            while (selectedCategories.options.length > 0) {
                var option = selectedCategories.options[0];
                availableCategories.appendChild(option);
            }
        };
    </script>
@endsection
