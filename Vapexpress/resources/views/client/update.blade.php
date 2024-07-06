@extends('template.app')

@section('content')
    <div class="flex flex-col justify-center pb-6 py-2 sm:px-6 lg:px-8 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold ">
                Editar Perfil
            </h2>
        </div>


        <div class="mt-4  sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form method="POST" action="{{ route('user.update', ['id' => $user->id]) }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name"
                            class="block text-sm font-medium leading-5  text-navbar @error('name') border-red-500 @enderror">Nombre</label>

                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="name" name="name" placeholder="usuario" type="text" required
                                value="{{ $user->name }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('name')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Nombre no válido.</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-6">
                        <label for="email"
                            class="block text-sm font-medium leading-5 text-navbar @error('email') border-red-500 @enderror">Correo
                            Electrónico</label>

                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="email" name="email" placeholder="usario@gmail.com" type="email" required
                                value="{{ $user->email }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('email')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Correo Electrónico no válido</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm leading-5">
                            <a href="{{ route('user.edit_password') }}"
                                class="font-medium text-navbar hover:text-text_principal focus:outline-none focus:underline transition ease-in-out duration-150">
                                ¿Quieres cambiar la contraseña?
                            </a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md
                                 text-white bg-navbar hover:bg-text_principal focus:outline-none
                                  focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Actualizar perfil
                            </button>
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
