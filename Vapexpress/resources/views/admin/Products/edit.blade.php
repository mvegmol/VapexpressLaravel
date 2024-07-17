@extends('template.app')

@section('content')
    <div class="container mx-auto p-6">
        @include('template.partials.alert')
        <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg">
            <div class="bg-navbar text-white p-6 flex justify-between items-center rounded-t-lg">
                <h1 class="text-3xl font-bold">Editar Producto</h1>
                <a href="{{ route('products.index') }}" class="bg-white text-navbar py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>

            <div class="p-6">
                <form id="productForm" method="POST" action="{{ route('products.update', $product) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Información del producto y proveedor -->
                        <div class="lg:col-span-1">
                            <div class="mb-4">
                                <label for="name" class="block text-base font-medium text-gray-700 py-2">Nombre del
                                    Producto</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $product->name) }}"
                                    class="border border-gray-300 p-2 rounded w-full @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                    class="block text-base font-medium text-gray-700 py-2">Descripción</label>
                                <textarea name="description" id="description" rows="4"
                                    class="border border-gray-300 p-2 rounded w-full @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-base font-medium text-gray-700 py-2">Precio</label>
                                <input type="text" name="price" id="price"
                                    value="{{ old('price', $product->price) }}"
                                    class="border border-gray-300 p-2 rounded w-full @error('price') border-red-500 @enderror">
                                @error('price')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="stock" class="block text-base font-medium text-gray-700 py-2">Stock</label>
                                <input type="number" name="stock" id="stock"
                                    value="{{ old('stock', $product->stock) }}"
                                    class="border border-gray-300 p-2 rounded w-full @error('stock') border-red-500 @enderror">
                                @error('stock')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="url_image" class="block text-base font-medium text-gray-700 py-2">Cambiar Imagen
                                    del Producto</label>
                                <div class="custom-file-input-container">
                                    <input type="file" name="url_image" id="url_image" class="custom-file-input">
                                    <label for="url_image" class="custom-file-label">Seleccionar archivo</label>
                                    <span id="file-chosen" class="custom-file-chosen">No se ha seleccionado ningún
                                        archivo</span>
                                </div>
                                @error('url_image')
                                    <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                                @enderror
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
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == $product->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="block text-base font-medium text-gray-700 py-2">Categorías</label>
                            <input type="hidden" name="categories" id="hiddenCategories" value="">
                            <div class="flex space-x-4">
                                <div class="w-1/3">
                                    <h2 class="text-base font-medium text-gray-700 mb-2">Categorías Disponibles:</h2>
                                    <select id="availableCategories" class="border border-gray-300 p-2 rounded w-full"
                                        multiple size="10">
                                        @foreach ($categories as $category)
                                            @if (!$product->categories->contains($category))
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
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
                                    <select id="selectedCategories" class="border border-gray-300 p-2 rounded w-full"
                                        multiple size="10">
                                        @foreach ($product->categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Mostrar la imagen existente -->
                            @if ($product->url_image)
                                <div class="mt-6">
                                    <label class="block text-base font-medium text-gray-700 py-2">Imagen Actual:</label>
                                    <img src="{{ asset('img/productos/' . $product->url_image) }}"
                                        alt="Imagen del Producto" class="w-32 h-32 object-cover">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" class="bg-navbar text-white px-6 py-3 rounded-lg">Actualizar
                            Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .custom-file-input-container input[type="file"] {
            display: block;
            width: 100%;
        }

        .custom-file-input-container input[type="file"]::file-selector-button {
            display: block;
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
            updateHiddenCategories();
        };

        document.getElementById('removeCategory').onclick = function() {
            var selectedCategories = document.getElementById('selectedCategories');
            var availableCategories = document.getElementById('availableCategories');
            while (selectedCategories.selectedOptions.length > 0) {
                var option = selectedCategories.selectedOptions[0];
                availableCategories.appendChild(option);
            }
            updateHiddenCategories();
        };

        document.getElementById('addAllCategories').onclick = function() {
            var availableCategories = document.getElementById('availableCategories');
            var selectedCategories = document.getElementById('selectedCategories');
            while (availableCategories.options.length > 0) {
                var option = availableCategories.options[0];
                selectedCategories.appendChild(option);
            }
            updateHiddenCategories();
        };

        document.getElementById('removeAllCategories').onclick = function() {
            var selectedCategories = document.getElementById('selectedCategories');
            var availableCategories = document.getElementById('availableCategories');
            while (selectedCategories.options.length > 0) {
                var option = selectedCategories.options[0];
                availableCategories.appendChild(option);
            }
            updateHiddenCategories();
        };

        function updateHiddenCategories() {
            var selectedCategories = document.getElementById('selectedCategories');
            var hiddenCategories = document.getElementById('hiddenCategories');
            hiddenCategories.value = Array.from(selectedCategories.options).map(option => option.value).join(',');
        }

        document.getElementById('url_image').onchange = function() {
            var input = this;
            var fileChosen = document.getElementById('file-chosen');
            fileChosen.textContent = input.files[0] ? input.files[0].name : 'No se ha seleccionado ningún archivo';
        };

        document.getElementById('productForm').onsubmit = function() {
            updateHiddenCategories();
        };
    </script>
@endsection
