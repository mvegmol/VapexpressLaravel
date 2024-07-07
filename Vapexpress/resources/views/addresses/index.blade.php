@extends('template.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold my-4">Mis direcciones</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Añadir dirección --}}
            <a href=""
                class="bg-white shadow-md rounded-md p-6 flex flex-col items-center justify-center hover:bg-gray-100 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 mb-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                <h2 class="text-xl font-semibold mb-2">Añadir dirección</h2>
                <p class="text-gray-600 text-center">Agrega una nueva dirección para tus envíos.</p>
            </a>

            {{-- Mostrar direcciones disponibles --}}

            @foreach ($addresses as $address)
                <div
                    class="bg-white shadow-md rounded-md p-6 flex flex-col justify-between hover:bg-gray-100 transition ease-in-out duration-150">
                    <div>
                        <h2 class="text-xl font-semibold mb-2">{{ $address->full_name }}</h2>
                        <p class="text-gray-600">{{ $address->direction }}, {{ $address->city }}, {{ $address->province }}
                            {{ $address->zip_code }}</p>
                        <p class="text-gray-600">{{ $address->contact_phone }}</p>
                    </div>
                    <div class="mt-4 flex space-x-4">
                        <a href="{{ route('addresses.edit', $address->id) }}"
                            class="text-indigo-600 hover:underline">Modificar</a>
                        <form action="{{ route('addresses.destroy', $address->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
