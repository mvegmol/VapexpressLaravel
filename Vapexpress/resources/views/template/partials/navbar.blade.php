<head>
    @vite('resources/css/app.css', 'resources/css/app.scss')
</head>

{{-- barra de navegación --}}

<nav class="bg-navbar text-text_navbar">
    <div class="container flex">
        <div class="px-8 py-4 bg-navbar flex items-center cursor-pointer">
            <span>
                <i class="fas fa-bars"></i>
            </span>
            <span class="capitalize ml-2">Todas las categorías</span>
        </div>
        <div class="flex items-center justify-between flex-grow pl-12">
            <div class="flex items-center space-x-6 capitalize">
                <a href="" class="transition text-text_a hover:text-text_a-dark">Home</a>
                <a href="" class="transition text-text_a hover:text-text_a-dark">Shop</a>
                <a href="" class="transition text-text_a hover:text-text_a-dark">Sobre Nosotros</a>
                <a href="" class="transition text-text_a hover:text-text_a-dark">Contactanos</a>

            </div>
            @guest
                <div class="flex items-center space-x-6 capitalize">
                    <a href="{{ route('login') }}" class="transition text-text_a hover:text-text_a-dark">Inciar Sesión</a>
                    <a href="{{ route('register') }}" class="transition text-text_a hover:text-text_a-dark">Registro</a>
                </div>
            @else
                <div class="flex items-center space-x-6 capitalize">
                    <a href="#perfil" class="transition text-text_a hover:text-text_a-dark">Perfil</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        class="transition text-text_a hover:text-text_a-dark">
                        @csrf
                        <button type="submit">Cerrar Sesión</button>
                    </form>
                    </a>

                </div>
            @endguest

        </div>
    </div>
</nav>


{{-- <nav class="bg-navbar text-text_navbar p-4">
    <ul class="flex justify-center space-x-6">
        <li><a href="#" class="text-text_a">Inicio</a></li>
        <li><a href="#" class="text-text_a">Productos</a></li>
        <li><a href="#" class="text-text_a">Contacto</a></li>
    </ul>
</nav> --}}
