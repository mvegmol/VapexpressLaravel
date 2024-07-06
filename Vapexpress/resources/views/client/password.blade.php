@extends('template.app')

@section('content')
    <div class="container mx-auto p-4 my-6">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                @if (session('status') == 'password-updated')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        {{ __('Password updated successfully') }}
                    </div>
                @endif
                <div class="bg-white shadow-md rounded-lg">
                    <h2 class="bg-primary px-6 py-3 rounded-t-lg font-semibold text-center text-xl text-white">
                        {{ __('Change Password') }}
                    </h2>

                    <div class="p-6">
                        <form method="POST" action="{{ route('user-password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="current_password"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('Current Password') }}</label>
                                <div>
                                    <input id="current_password" type="password"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password', 'updatePassword') border-red-500 @enderror"
                                        name="current_password" required autofocus>

                                    @error('current_password', 'updatePassword')
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
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password', 'updatePassword') border-red-500 @enderror"
                                        name="password" required autocomplete="new-password">

                                    @error('password', 'updatePassword')
                                        <span class="text-red-500 text-sm mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('Confirm Password') }}</label>
                                <div>
                                    <input id="password-confirm" type="password"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="flex items-center justify-center">
                                <button type="submit"
                                    class="bg-primary text-white hover:bg-tertiary font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
