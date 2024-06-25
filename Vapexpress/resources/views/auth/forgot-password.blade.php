@extends('template.app')

@section('content')
    <div class="container mx-auto p-4 my-6">
        <div class="flex justify-center">
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white shadow-md rounded-lg">
                    <div class="bg-primary text-white px-6 py-3 rounded-t-lg font-semibold">
                        {{ __('Reset password') }}
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('password.request') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>
                                <div>
                                    <input id="email" type="email"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="text-red-500 text-sm mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <button type="submit"
                                    class="bg-primary hover:bg-tertiary  text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('Send Email') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
