@extends('template.app')

@section('content')
    @include('template.partials.alert')
    <div class="container mx-auto p-3">

        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg ">
            <div class="bg-navbar text-white p-4 flex justify-between items-center rounded-lg">
                <h1 class="text-3xl font-bold">Crear Categoría</h1>
                <a href="{{ route('categories.index') }}" class="bg-white text-navbar py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>

            <div class="p-6 shadow-lg rounded-lg">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-base font-medium text-gray-700 py-2">Nombre de la
                            Categoría</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="border border-gray-300 p-2 rounded w-full @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-base font-medium text-gray-700 py-2">Descripción</label>
                        <textarea name="description" id="description" rows="4"
                            class="border border-gray-300 p-2 rounded w-full @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-navbar text-white px-6 py-3 rounded-lg">Crear Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
