@extends('template.app')

@section('content')
    <div class="container mx-auto p-3">
        @include('template.partials.alert')
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg ">
            <div class="bg-navbar text-white p-4 flex justify-between items-center rounded-lg">
                <h1 class="text-3xl font-bold">Actualizar Proveedor</h1>
                <a href="{{ route('suppliers.index') }}" class="bg-white text-navbar py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>

            <div class="p-6 shadow-lg rounded-lg">
                <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-base font-medium text-gray-700 py-2">Nombre del
                            Proveedor</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}"
                            class="border border-gray-300 p-2 rounded w-full @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="contact_name" class="block text-base font-medium text-gray-700 py-2">Nombre de
                            Contacto</label>
                        <input type="text" name="contact_name" id="contact_name"
                            value="{{ old('contact_name', $supplier->contact_name) }}"
                            class="border border-gray-300 p-2 rounded w-full @error('contact_name') border-red-500 @enderror">
                        @error('contact_name')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-base font-medium text-gray-700 py-2">Número de
                            Contacto</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}"
                            class="border border-gray-300 p-2 rounded w-full @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-base font-medium text-gray-700 py-2">Correo
                            Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}"
                            class="border border-gray-300 p-2 rounded w-full @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-md mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-navbar text-white px-6 py-3 rounded-lg">Actualizar
                            Proveedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
