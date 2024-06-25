@extends('template.app')

@section('content')
    <div class="container mx-auto p-4 my-6">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white shadow-md rounded-lg">
                    <h2 class="bg-primary px-6 py-3 rounded-t-lg font-semibold text-center text-xl text-white	">
                        {{ __('Login') }}
                    </h2>

                    <div class="p-6">
                        <form method="POST" action="{{ route('login') }}">
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

                            <div class="mb-4">
                                <label for="password"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('Password') }}</label>
                                <div>
                                    <input id="password" type="password"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                                        name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="text-red-500 text-sm mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center">
                                    <input class="form-check-input mr-2 leading-tight" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="text-gray-700 text-sm font-bold" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit"
                                    class="bg-primary text-white hover:bg-tertiary font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="inline-block align-baseline font-bold text-sm  hover:text-primary"
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
