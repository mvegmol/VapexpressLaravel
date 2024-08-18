<head>
    @vite('resources/css/app.css', 'resources/css/app.scss')
</head>

{{-- barra de navegación --}}


@if (Auth::check() && Auth::user()->isAdmin())
    {{-- <div class="container flex py-3 text-center">

            <div class="flex items-center justify-between flex-grow pl-12">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="" class="transition text-text_a hover:text-text_a-dark">Productos</a>
                    <a href="" class="transition text-text_a hover:text-text_a-dark">Categorias</a>
                    <a href="" class="transition text-text_a hover:text-text_a-dark">Proveedores</a>
                    <a href="" class="transition text-text_a hover:text-text_a-dark">Pedidos</a>

                </div>
            </div>
        </div> --}}
@else
    <nav id="navbar" class="px-8 bg-navbar text-text_navbar">
        <div class="container flex">

            <div class="px-8 py-4 bg-navbar flex items-center cursor-pointer relative group">
                <span>
                    <i class="fas fa-bars"></i>
                </span>
                <span class="capitalize ml-2">Categorías Destacadas</span>
                <div
                    class="absolute w-full left-0 top-full bg-white rounded-lg shadow-md py-2 divide-y divide-gray-400 divide-dashed hidden group-hover:block group-hover:opacity-100 transition">

                    <!-- Filtro por tipo de vape -->
                    <a href="{{ route('products.search', ['type' => 'Vaper Recargable']) }}"
                        class="flex items-center px-6 py-3 text-black hover:bg-gray-200 transition">
                        <p class="ml-3 text-sm">Vapers Recargable</p>
                    </a>
                    <a href="{{ route('products.search', ['type' => 'Vaper Desechables']) }}"
                        class="flex items-center px-6 py-3 text-black hover:bg-gray-200 transition">
                        <p class="ml-3 text-sm">Vapers Desechable</p>
                    </a>



                    <!-- Filtro por categoría (Líquido, Vape, Accesorios) -->
                    <a href="{{ route('products.search', ['category' => 'E-líquidos']) }}"
                        class="flex items-center px-6 py-3 text-black hover:bg-gray-200 transition">
                        <p class="ml-3 text-sm">Líquido</p>
                    </a>
                    <a href="{{ route('products.search', ['category' => 'Vaper']) }}"
                        class="flex items-center px-6 py-3 text-black hover:bg-gray-200 transition">
                        <p class="ml-3 text-sm">Vapers</p>
                    </a>
                    <a href="{{ route('products.search', ['category' => 'Accesorios']) }}"
                        class="flex items-center px-6 py-3 text-black hover:bg-gray-200 transition">
                        <p class="ml-3 text-sm">Accesorios</p>
                    </a>


                </div>
            </div>
            <div class="flex items-center justify-between flex-grow pl-12">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="{{ route('home') }}" class="transition text-text_a hover:text-text_a-dark">Home</a>
                    <a href="{{ route('products.search') }}"
                        class="transition text-text_a hover:text-text_a-dark">Productos</a>
                    <a href="{{ route('order.index') }}"
                        class="transition text-text_a hover:text-text_a-dark">Pedidos</a>
                    <a href="{{ route('about') }}" class="transition text-text_a hover:text-text_a-dark">Sobre
                        Nosotros</a>
                    <a href="{{ route('contact') }}"
                        class="transition text-text_a hover:text-text_a-dark">Contactanos</a>
                </div>
                @guest
                    <div class="flex items-center space-x-6 capitalize">
                        <a href="{{ route('login') }}" class="transition text-text_a hover:text-text_a-dark">Inciar
                            Sesión</a>
                        <a href="{{ route('register') }}"
                            class="transition text-text_a hover:text-text_a-dark">Registro</a>
                    </div>
                @endguest

            </div>
        </div>
    </nav>
@endif




{{-- <nav class="bg-navbar text-text_navbar p-4">
    <ul class="flex justify-center space-x-6">
        <li><a href="#" class="text-text_a">Inicio</a></li>
        <li><a href="#" class="text-text_a">Productos</a></li>
        <li><a href="#" class="text-text_a">Contacto</a></li>
    </ul>
</nav> --}}
