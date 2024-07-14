@extends('template.app')

@section('content')
    @if (Auth::check() && Auth::user()->isAdmin())
        <div class="container mx-auto px-4">
            {{-- alertar y mensajes para para el usuario --}}
            @include('template.partials.alert')
            <h1 class="text-3xl font-bold my-4">Bienvenido {{ $user_name }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Modificar datos -->
                <a href="{{ route('user.edit', ['id' => $user_id]) }}">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/editar.png') }}" alt="Modificar datos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Modificar datos</h2>
                            <p class="text-gray-600">Actualiza tu información del administrador.</p>
                        </div>
                    </div>
                </a>

                <!-- Pedidos -->
                <a href="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/pedido.png') }}" alt="Mis pedidos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Pedidos</h2>
                            <p class="text-gray-600">Revisa los pedidos.</p>
                        </div>
                    </div>
                </a>
                {{-- Productos --}}
                <a href="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/liquido.png') }}" alt="Mis pedidos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Productos</h2>
                            <p class="text-gray-600">Gestiona los productos disponibles.</p>
                        </div>
                    </div>
                </a>
                {{-- categorias --}}
                <a href="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/categorias.png') }}" alt="Mis pedidos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Categorías</h2>
                            <p class="text-gray-600">Gestiona las categorías de los productos.</p>
                        </div>
                    </div>
                </a>
                {{-- Proveedores --}}
                <a href="{{ route('suppliers.index') }}">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/gestion.png') }}" alt="Mis pedidos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Proveedores</h2>
                            <p class="text-gray-600">Gestión de los proveedores.</p>
                        </div>
                    </div>
                </a>

                <!-- Logout -->
                <a href="" class="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/cerrar-sesion.png') }}" alt="Logout" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Logout</h2>
                            <p class="text-gray-600">Cierra la sesión.</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    @else
        <div class="container mx-auto px-4">
            @include('template.partials.alert')
            <h1 class="text-3xl font-bold my-4">Bienvenido {{ $user_name }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Modificar datos -->
                <a href="{{ route('user.edit', ['id' => $user_id]) }}">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/editar.png') }}" alt="Modificar datos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Modificar datos</h2>
                            <p class="text-gray-600">Actualiza tu información personal.</p>
                        </div>
                    </div>
                </a>
                <!-- Mis direcciones -->
                <a href="{{ route('addresses.index') }}">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/mapa.png') }}" alt="Mis direcciones" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Mis direcciones</h2>
                            <p class="text-gray-600">Gestiona tus direcciones de envío.</p>
                        </div>
                    </div>
                </a>
                <!-- Pedidos -->
                <a href="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/pedido.png') }}" alt="Mis pedidos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Mis pedidos</h2>
                            <p class="text-gray-600">Revisa y gestiona tus pedidos.</p>
                        </div>
                    </div>
                </a>

                <!-- Favoritos -->
                <a href="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/favoritos.png') }}" alt="Favoritos" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Favoritos</h2>
                            <p class="text-gray-600">Gestiona tus productos favoritos</p>
                        </div>
                    </div>
                </a>

                <!-- Soporte -->
                <a href="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/soporte.png') }}" alt="Soporte" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Soporte</h2>
                            <p class="text-gray-600">Contacta con nuestro equipo de soporte.</p>
                        </div>
                    </div>
                </a>

                <!-- Logout -->
                <a href="" class="">
                    <div class="bg-white shadow-md rounded-md py-8 px-6 flex items-center hover:bg-gray-100">
                        <img src="{{ asset('img/icons/cerrar-sesion.png') }}" alt="Logout" class="w-16 h-16 mr-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Logout</h2>
                            <p class="text-gray-600">Cierra la sesión.</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    @endif
@endsection
