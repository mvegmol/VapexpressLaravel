@extends('template.app')

@section('content')
    <div class="flex flex-col justify-center pb-6 py-2 sm:px-6 lg:px-8 px-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                Enlace de verificación enviado.
            </div>
        @endif
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold ">
                Correo de verificación
            </h2>
        </div>
        <div class="mt-4  sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <p class="mt-2 text-center text-sm leading-5 text-blue-600 max-w">
                        Debes verificar tu dirección de correo electrónico. Por favor, revisa tu correo electrónico para
                        encontrar
                        un enlace de verificación.
                    </p>

                    <div class="mt-3">
                        <span class="block w-full rounded-md shadow-sm">
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md
                                 text-white bg-navbar hover:bg-text_principal focus:outline-none
                                  focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Reenviar Correo
                            </button>
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
