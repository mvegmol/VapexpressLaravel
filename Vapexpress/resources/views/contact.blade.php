@extends('template.app')
@section('content')
    <h2 class="text-4xl font-bold text-navbar mb-6 text-center">Contacta con Nosotros</h2>
    <div class="flex bg-white p-8 rounded shadow-md w-full max-w-6xl mx-auto border">
        <!-- Contact Information with Map -->
        <div class="w-full md:w-1/2 p-6 rounded-l-lg">
            <div class="mb-6">
                <iframe class="w-full h-64 rounded-lg"
                    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d256.0337922895268!2d-5.911274211801038!3d37.28577586782646!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sEdificios%20Vistazul%2C%203%2C%20Dos%20Hermanas!5e0!3m2!1ses!2ses!4v1721675266871!5m2!1ses!2ses"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <h2 class="text-3xl font-bold mb-4">VAPEXPRESS</h2>
            <p class="mb-4">Rellena el formulario para iniciar una conversación.</p>
            <div class="mb-4">
                <p class="flex items-center text-gray-700">
                    <i class="fas fa-map-marker-alt w-6 h-6 mr-2"></i>
                    Dos Hermanas,<br>Edificios Vistazul Bloque 2, Sevilla, 41702
                </p>
            </div>
            <div class="mb-4">
                <p class="flex items-center text-gray-700">
                    <i class="fas fa-phone w-6 h-6 mr-2"></i>
                    +34 678 867 870
                </p>
            </div>
            <div class="mb-4">
                <p class="flex items-center text-gray-700">
                    <i class="fas fa-envelope w-6 h-6 mr-2"></i>
                    vapexpress@gmail.com
                </p>
            </div>
        </div>
        <!-- Contact Form -->
        <div class="w-full md:w-1/2 p-6 rounded-r-lg">
            <form action="{{ route('sendemail') }}" method="POST">
                @method('POST')
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-navbar font-bold mb-2">Nombre Completo</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-navbar font-bold mb-2">Correo Electrónico</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-navbar font-bold mb-2">Número de teléfono</label>
                    <input type="text" id="phone" name="phone"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>

                <div class="mb-4">
                    <label for="message" class="block text-navbar font-bold mb-2">Mensaje</label>
                    <textarea id="message" name="message" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"
                        required></textarea>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-navbar text-white font-bold py-2 px-4 rounded hover:bg-blue-900 focus:outline-none focus:bg-blue-900">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
