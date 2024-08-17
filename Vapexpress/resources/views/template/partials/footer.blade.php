<footer class="bg-navbar text-text_navbar py-8 mt-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-between">
            <!-- Sobre Nosotros -->
            <div class="w-full sm:w-1/4 mb-6 sm:mb-0">
                <h5 class="text-lg font-semibold mb-4 text-text_a-dark">Información Vapexpress</h5>

                <ul class="space-y-2">
                    <li><a class="transition text-text_a hover:text-text_a-dark">Sobre
                            Nosotros</a></li>
                    <li><a class="transition text-text_a hover:text-text_a-dark">Leyes
                            sobre el vapeo</a></li>
                </ul>
            </div>
            <!-- Links Rápidos -->
            <div class="w-full sm:w-1/4 mb-6 sm:mb-0">
                <h5 class="text-lg font-semibold mb-4 text-text_a-dark">Links Rápidos</h5>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="transition text-text_a hover:text-text_a-dark">Home</a>
                    </li>
                    <li><a href="{{ route('products.search') }}"
                            class="transition text-text_a hover:text-text_a-dark">Productos</a></li>
                    <li><a href="{{ route('order.index') }}"
                            class="transition text-text_a hover:text-text_a-dark">Pedidos</a></li>
                    <li><a href="{{ route('contact') }}"
                            class="transition text-text_a hover:text-text_a-dark">Contactanos</a></li>
                </ul>
            </div>
            <!-- Categorías -->
            <div class="w-full sm:w-1/4 mb-6 sm:mb-0">
                <h5 class="text-lg font-semibold mb-4 text-text_a-dark">Categorías</h5>
                <ul class="space-y-2">
                    <li><a href="{{ route('products.search', ['category' => 'E-líquidos']) }}"
                            class="transition text-text_a hover:text-text_a-dark">Líquidos</a></li>
                    <li><a href="{{ route('products.search', ['category' => 'Vaper']) }}"
                            class="transition text-text_a hover:text-text_a-dark">Vapers</a></li>
                    <li><a href="{{ route('products.search', ['category' => 'Accesorios']) }}"
                            class="transition text-text_a hover:text-text_a-dark">Accesorios</a></li>
                </ul>
            </div>
            <!-- Contacto -->
            <div class="w-full sm:w-1/4">
                <h5 class="text-lg font-semibold mb-4 text-text_a-dark">Contacto</h5>
                <ul class="space-y-2">
                    <li><a href="mailto:info@vapexpress.com"
                            class="transition text-text_a hover:text-text_a-dark">vapexpress@gmail.com</a></li>
                    <li><a href="tel:+123456789" class="transition text-text_a hover:text-text_a-dark">+34 678 867 870
                        </a>
                    </li>
                    <li><a href="{{ route('contact') }}"
                            class="transition text-text_a hover:text-text_a-dark">Formulario de Contacto</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-4 text-center">
            <p class="text-sm text-text_a">© 2024 Vapexpress, Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
