<div class="container mx-auto p-4 my-6">
    <div class="flex justify-center">
        <div class="w-full md:w-2/3 lg:w-1/2">
            <div class="bg-white shadow-md rounded-lg">
                <div class="bg-gray-200 px-6 py-3 rounded-t-lg font-semibold">
                    {{ __('Reset password') }}
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-4">
                            <label for="email"
                                class="block text-gray-700 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>
                            <div>
                                <input id="email" type="email"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                                    name="email" value="{{ $request->email }}" required autofocus>

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
                                    name="password" required autocomplete="new-password">

                                @error('password')
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

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                value="Update">
                                {{ __('Reset') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
