@extends('template.app')

@section('content')
    <div class="container mx-auto p-4 mt-6">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white shadow-md rounded-lg">
                    <div class="bg-primary text-white px-6 py-3 rounded-t-lg font-semibold">
                        {{ __('Update Profile') }}
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('user.update', ['id' => Auth::user()->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="name"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}</label>
                                <div>
                                    <input id="name" type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                                        name="name" value="{{ Auth::user()->name }}" required autocomplete="name"
                                        autofocus>

                                    @error('name')
                                        <span class="text-red-500 text-sm mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>
                                <div>
                                    <input id="email" type="email"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                                        name="email" value="{{ Auth::user()->email }}" required autocomplete="email"
                                        disabled>

                                    @error('email')
                                        <span class="text-red-500 text-sm mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="phone"
                                    class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone Number') }}</label>
                                <div>
                                    <input id="phone" type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror"
                                        name="phone" value="{{ Auth::user()->phone }}" required autocomplete="phone">

                                    @error('phone')
                                        <span class="text-red-500 text-sm mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="flex justify-between items-center my-2">
                                <button type="submit"
                                    class="bg-primary hover:bg-tertiary text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('Update Profile') }}
                                </button>
                                <div>

                                    <a class="inline-block align-baseline font-bold text-sm text-primary hover:text-tertiary"
                                        href="{{ route('profile.changepass') }}">
                                        {{ __('Change Your Password?') }}
                                    </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
