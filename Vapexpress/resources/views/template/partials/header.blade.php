<head>
    @vite('resources/css/app.css', 'resources/css/app.scss')
</head>
{{-- header --}}
<header class="py-4 px-8 shodow-sm bg-white">
    <div class="container flex items-center justify-between">


        {{-- logo --}}
        <a href="#">
            <img src="{{ asset('/img/logo.png') }}" alt="Logo de Vapexpress" class="w-48">
        </a>
        {{-- barra busqueda --}}
        <div class="w-full max-w-xl relative flex">
            <span class="absolute left-4 top-3 text-lg text-navbar">
                <i class="fas fa-search">
                </i>
            </span>
            <input type="text"
                class="w-full border border-navbar border-r-0 pl-12 py-3 pr-3 rounded-l-md focus:outline-none"
                placeholder="Buscar productos">
            <button
                class="bg-navbar border border-navbar text-text_navbar px-8 rounded-r-md hover:bg-transparent hover:text-navbar transition ">Buscar</button>
        </div>

        <div class="flex items-center space-x-4">

            {{-- icono de me gusta --}}
            <a href="#" class="text-center text-gray-600 hover:text-navbar transition relative">
                <div class="text-2xl">
                    <i class="far fa-heart text-navbar"></i>
                </div>

                <div class="text-xs leading-3">
                    Favoritos
                </div>
                <span
                    class="absolute right-0 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-navbar text-xs text-white">1</span>

            </a>

            {{-- icono del carrito de la compra  --}}
            <a href="#" class="text-center text-gray-600 hover:text-navbar transition relative">
                <div class="text-2xl">
                    <i class="fa fa-shopping-cart text-navbar"></i>
                </div>

                <div class="text-xs leading-3">
                    Carrito
                </div>
                <span
                    class="absolute right-0 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-navbar text-xs text-white">1</span>

            </a>




            {{-- icono de usuario --}}
            <a href="@guest {{ route('register') }} @else {{ route('login') }} @endguest"
                class="text-center text-gray-600 hover:text-navbar transition relative ">
                <div class="text-2xl">
                    <i class="far fa-user text-navbar"></i>
                </div>
                @guest
                    <div class="text-xs leading-3">
                        Cuenta
                    </div>
                @else
                    <div class="text-xs leading-3 ">
                        {{ Auth::user()->name }}
                    </div>

                @endguest
            </a>



            {{-- icono de logout --}}
            @guest
            @else
                <a href="#" class="text-center text-gray-600 hover:text-navbar transition relative">
                    <div class="text-2xl">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>

                    <div class="text-xs leading-3">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Cerrar Sesión</button>
                    </div>
                </a>
            @endguest

            @csrf



        </div>
    </div>
</header>
