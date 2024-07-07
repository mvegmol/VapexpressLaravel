@extends('template.app')


@section('content')
    <div class="flex flex-col justify-center pb-6 py-2 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold ">
                Agregar Nueva dirección
            </h2>

        </div>


        <div class="mt-4  sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form method="POST" action="{{ route('addresses.store') }}">
                    @method('POST')
                    @csrf
                    <div>
                        <label for="full_name" class="block text-sm font-medium leading-5  text-navbar">Nombre de
                            contacto</label>

                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="full_name" name="full_name" placeholder="Miguel" type="text" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5
                                @error('full_name') border-red-500 @enderror">
                        </div>
                        @error('full_name')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Nombre incorrecto.</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-6">
                        <label for="contact_phone" class="block text-sm font-medium leading-5  text-navbar">Número de
                            Contacto</label>

                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="contact_phone" name="contact_phone" placeholder="678867870" type="text" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5
                                @error('contact_phone') border-red-500 @enderror">
                        </div>
                        @error('contact_phone')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Número de teléfono incorrecto.</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-6">
                        <label for="direction" class="block text-sm font-medium leading-5  text-navbar">Calle</label>

                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="direction" name="direction" placeholder="Edificio Vistazul Bloque 2" type="text"
                                required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5
                                @error('direction') border-red-500 @enderror">
                        </div>
                        @error('direction')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Calle incorrecta.</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label for="city" class="block text-sm font-medium leading-5 text-navbar">Ciudad</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="city" name="city" type="text" required placeholder="Dos Hermanas"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md 
                                placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 
                                transition duration-150 ease-in-out sm:text-sm sm:leading-5
                                 @error('city') border-red-500 @enderror">

                        </div>
                        @error('city')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Ciudad incorrecta.</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="mt-6">
                        <label for="province" class="block text-sm font-medium leading-5 text-navbar">Provincia</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="province" name="province" type="text" required placeholder="Sevilla"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md 
                                placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 
                                transition duration-150 ease-in-out sm:text-sm sm:leading-5
                                 @error('province') border-red-500 @enderror">

                        </div>
                        @error('province')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Provincia incorrecta.</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label for="zip_code" class="block text-sm font-medium leading-5 text-navbar">Código Postal</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="zip_code" name="zip_code" type="text" required placeholder="41702"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md 
                                placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 
                                transition duration-150 ease-in-out sm:text-sm sm:leading-5
                                 @error('zip_code') border-red-500 @enderror">

                        </div>
                        @error('zip_code')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Código Postal incorrecto.</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md
                                 text-white bg-navbar hover:bg-text_principal focus:outline-none
                                  focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Añadir dirección
                            </button>
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
