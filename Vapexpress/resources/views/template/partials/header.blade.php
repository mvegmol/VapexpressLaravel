<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- header admin --}}
@if (Auth::check() && Auth::user()->isAdmin())
    <header id="header" class="py-2 px-6 shadow-sm bg-navbar text-text_navbar">
        <div class="container mx-auto flex flex-wrap items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('index_admin') }}" class="mb-2 sm:mb-0">
                <img src="{{ asset('/img/logo.png') }}" alt="Logo de Vapexpress" class="w-36 sm:w-48">
            </a>

            {{-- Menu Toggle for mobile --}}
            <div class="block lg:hidden">
                <button id="nav-toggle"
                    class="flex items-center px-3 py-2 border rounded text-text_navbar border-text_navbar hover:text-text_a-dark hover:border-text_a-dark">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0zM0 7h20v2H0zM0 11h20v2H0z" />
                    </svg>
                </button>
            </div>

            {{-- Links --}}
            <div id="nav-content"
                class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-4 lg:mt-0">
                <div class="lg:flex-grow lg:flex lg:justify-end lg:space-x-8">

                    {{-- Productos --}}
                    <a href="{{ route('products.index') }}"
                        class="block lg:inline-block text-center hover:text-text_a-dark transition">
                        <div class="text-lg lg:text-xl">
                            Productos
                        </div>
                    </a>

                    {{-- Categorías --}}
                    <a href="{{ route('categories.index') }}"
                        class="block lg:inline-block text-center hover:text-text_a-dark transition">
                        <div class="text-lg lg:text-xl">
                            Categorías
                        </div>
                    </a>

                    {{-- Proveedores --}}
                    <a href="{{ route('suppliers.index') }}"
                        class="block lg:inline-block text-center hover:text-text_a-dark transition">
                        <div class="text-lg lg:text-xl">
                            Proveedores
                        </div>
                    </a>

                    {{-- Pedidos --}}
                    <a href="{{ route('orders.admin.index') }}"
                        class="block lg:inline-block text-center hover:text-text_a-dark transition">
                        <div class="text-lg lg:text-xl">
                            Pedidos
                        </div>
                    </a>

                    {{-- Cuenta --}}
                    <a href="{{ route('user.profile') }}"
                        class="block lg:inline-block text-center hover:text-text_a-dark transition">
                        <div class="text-lg lg:text-xl">
                            Cuenta
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </header>

    <script>
        // Script para toggle del menú en móvil
        document.getElementById('nav-toggle').onclick = function() {
            var navContent = document.getElementById('nav-content');
            navContent.classList.toggle('hidden');
        };
    </script>
@else
    {{-- header client --}}
    <header id="header" class="py-4 px-4 md:px-8 shadow-sm bg-white">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            {{-- logo --}}
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('/img/logo.png') }}" alt="Logo de Vapexpress" class="w-32 md:w-48">
            </a>

            {{-- barra de búsqueda --}}
            <form action="{{ route('products.search') }}" method="GET"
                class="w-full max-w-md md:max-w-xl relative flex mt-4 md:mt-0">
                <span class="absolute left-4 top-3 text-lg text-navbar">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search"
                    class="w-full border border-navbar border-r-0 pl-12 py-2 md:py-3 pr-3 rounded-l-md focus:outline-none"
                    placeholder="Buscar productos">
                <button type="submit"
                    class="bg-navbar border border-navbar text-text_navbar px-4 md:px-8 rounded-r-md hover:bg-transparent hover:text-navbar transition">
                    Buscar
                </button>
            </form>

            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                {{-- icono de me gusta --}}
                <a href="{{ route('client.likes') }}"
                    class="text-center text-gray-600 hover:text-navbar transition relative">
                    <div class="text-xl md:text-2xl">
                        <i
                            class="{{ Auth::check() && Auth::user()->favoriteQuantity() > 0 ? 'fa' : 'far' }} fa-heart text-navbar"></i>
                    </div>
                    <div class="text-xs leading-3">
                        Favoritos
                    </div>
                    <span
                        class="absolute right-0 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-navbar text-xs text-white">{{ Auth::check() ? Auth::user()->favoriteQuantity() : 0 }}</span>
                </a>

                {{-- icono del carrito de la compra  --}}
                <a href="{{ route('shopping_cart') }}"
                    class="text-center text-gray-600 hover:text-navbar transition relative">
                    <div class="text-xl md:text-2xl">
                        <i class="fa fa-shopping-cart text-navbar"></i>
                    </div>
                    <div class="text-xs leading-3">
                        Carrito
                    </div>
                    <span
                        class="absolute right-0 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-navbar text-xs text-white">{{ Auth::check() ? Auth::user()->cartQuantity() : 0 }}</span>
                </a>

                {{-- icono de usuario --}}
                <a href="@guest {{ route('register') }} @else {{ route('user.profile') }} @endguest"
                    class="text-center text-gray-600 hover:text-navbar transition relative">
                    <div class="text-xl md:text-2xl">
                        <i class="{{ Auth::check() ? 'fa' : 'far' }} fa-user text-navbar"></i>
                    </div>
                    @guest
                        <div class="text-xs leading-3">
                            Cuenta
                        </div>
                    @else
                        <div class="text-xs leading-3">
                            {{ Auth::user()->name }}
                        </div>
                    @endguest
                </a>

                {{-- icono de logout --}}
                @guest
                @else
                    <a href="#" class="text-center text-navbar hover:text-navbar transition relative">
                        <div class="text-xl md:text-2xl">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="text-xs leading-3">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">Cerrar Sesión</button>
                            </form>
                        </div>
                    </a>
                @endguest
            </div>
        </div>
    </header>
@endif
