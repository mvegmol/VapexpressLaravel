@extends('template.app')
@section('content')
    <div class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Sobre Nosotros</h2>
                <p class="mt-4 text-lg leading-6 text-gray-600">
                    Bienvenidos a Vapexpress, tu tienda online de confianza para todo lo relacionado con el mundo del vapeo.
                    Nos encontramos en Dos Hermanas, Sevilla, y ofrecemos envíos a toda España.
                </p>
            </div>

            <div class="mt-10">
                <div class="flex flex-col md:flex-row md:justify-center">
                    <div class="md:w-1/2 lg:w-1/3 px-4">
                        <div class="bg-white shadow-lg rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-800">Nuestra Misión</h3>
                            <p class="mt-4 text-gray-600">
                                En Vapexpress, nos apasiona ofrecer a nuestros clientes productos de alta calidad a precios
                                competitivos. Nos esforzamos por ser líderes en el mercado español, proporcionando un
                                servicio excepcional y una experiencia de compra sencilla y segura.
                            </p>
                        </div>
                    </div>

                    <div class="md:w-1/2 lg:w-1/3 px-4 mt-6 md:mt-0">
                        <div class="bg-white shadow-lg rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-800">Nuestra Ubicación</h3>
                            <p class="mt-4 text-gray-600">
                                Nos ubicamos en Dos Hermanas, Sevilla, desde donde gestionamos todos nuestros envíos y
                                operaciones. Trabajamos incansablemente para garantizar que nuestros productos lleguen a su
                                destino de manera rápida y segura, en cualquier punto de España.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('legal') }}" class="text-indigo-600 hover:text-indigo-800">
                    Conoce las leyes sobre la venta de vapers en España
                </a>
            </div>
        </div>
    </div>
@endsection
