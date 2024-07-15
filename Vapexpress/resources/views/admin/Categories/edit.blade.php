@extends('template.app')

@section('content')
    <div class="container mx-auto p-3">
        @include('template.partials.alert')
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg ">
            <div class="bg-navbar text-white p-4 flex justify-between items-center rounded-lg">
                <h1 class="text-3xl font-bold">Actualizar Categoría</h1>
                <a href="{{ route('categories.index') }}" class="bg-white text-navbar py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>

            <div class="p-6 shadow-lg rounded-lg">
                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-base font-medium text-gray-700 py-2">Nombre del
                            Proveedor</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                            class="border border-gray-300 p-2 rounded w-full @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_name" class="block text-base font-medium text-gray-700 py-2">Nombre de
                            Contacto</label>
                        <textarea name="description" id="description" rows="4"
                            class="border border-gray-300 p-2 rounded w-full @error('description') border-red-500 @enderror">{{ old('contact_name', $category->description) }}</textarea>
                        @error('contact_name')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex justify-center">
                        <button type="submit" class="bg-navbar text-white px-6 py-3 rounded-lg">Actualizar
                            Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
