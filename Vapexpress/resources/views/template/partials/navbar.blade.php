<head>
    @vite('resources/css/app.css', 'resources/css/app.scss')
</head>

{{-- barra de navegación --}}

<nav class="px-8 bg-navbar text-text_navbar">
    <div class="container flex">
        <div class="px-8 py-4 bg-navbar flex items-center cursor-pointer relative group">
            <span>
                <i class="fas fa-bars"></i>
            </span>
            <span class="capitalize ml-2">Todas las categorías</span>
            <div
                class="absolute w-full left-0 top-full bg-white rounded-lg shadow-md py-2 divide-y divide-gray-400 divide-dashed hidden  group-hover:block group-hover:opacity-100 transition ">
                <a href="" class="flex items-center px-6 py-3 text-black  hover:bg-gray-200 transition">
                    <p class="ml-3 text-sm">Vaper</p>
                </a>
                <a href="" class="flex items-center px-6 py-3 text-black hover:bg-gray-200 transition">
                    <p class="ml-3 text-sm">Acesorios</p>
                </a>
                <a href="" class="flex items-center px-6 py-3 text-black hover:bg-gray-200 transition">
                    <p class="ml-3 text-sm">Todos los Productos</p>
                </a>
            </div>
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
