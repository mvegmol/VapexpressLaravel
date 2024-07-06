@extends('template.app')

@section('content')


    <div class="flex flex-col justify-center pb-6 py-2 sm:px-6 lg:px-8 px-6">

        @if (session('status') == 'password-updated')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ __('Contraseña actualizada correctamente') }}
            </div>
        @endif


        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold ">
                Actualizar Contraseña
            </h2>
        </div>
        <div class="mt-4  sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="current_password"
                            class="block text-sm font-medium leading-5  text-navbar @error('current_password') border-red-500 @enderror">Contraseña
                            actual</label>

                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="current_password" name="current_password" placeholder="********" type="password"
                                required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('current_password', 'updatePassword')
                            <span class="text-red-500 text-sm mt-2" role="alert">
                                <strong>Error al acutalizar la contraseña.</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-6">
                        <label for="password"
                            class="block text-sm font-medium leading-5 text-navbar @error('password') border-red-500 @enderror">Nueva
                            Contraseña</label>

                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="password" name="password" placeholder="********" type="password" required
                                autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 
                                focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="password-confirm"
                            class="block text-sm font-medium leading-5 text-navbar @error('password') border-red-500 @enderror">Repite
                            la contraseña</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="password-confirm" name="password_confirmation" type="password" required
                                placeholder="********"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">

                        </div>
                        @error('password')
                            @if ($message == 'The password field confirmation does not match.')
                                <span class="text-red-500 text-sm mt-2" role="alert">
                                    <strong>Las contraseñas no coinciden.</strong>
                                </span>
                            @else
                                <span class="text-red-500 text-sm mt-2" role="alert">
                                    <strong>La contraseña debe tener al menos 8 caracteres.</strong>
                                </span>
                            @endif
                        @enderror
                    </div>


                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md
                                 text-white bg-navbar hover:bg-text_principal focus:outline-none
                                  focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Actualizar Contraseña
                            </button>
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
