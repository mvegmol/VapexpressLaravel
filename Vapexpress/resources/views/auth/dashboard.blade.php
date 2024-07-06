@extends('template.app')

@section('content')
    <div class="flex flex-col justify-center pb-6 py-2 sm:px-6 lg:px-8 px-6">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold ">
                Dashboard
            </h2>
        </div>
        <div class="mt-4  sm:mx-auto sm:w-full sm:max-w-md">
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                Te ha registrado correctamente!
            </div>
        </div>
    </div>
@endsection
