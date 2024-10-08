<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vapexpress</title>
    {{-- Favicon  --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen flex flex-col  text-text_principal ">

    <header id="main-header" class="fixed top-0 left-0 w-full bg-white shadow-lg z-50 transition-transform transform">
        @include('template.partials.header')
        @include('template.partials.navbar')
    </header>
    <div class="pt-36">
        @yield('carousel')
    </div>

    <!-- Modal de Verificación de Edad -->


    <main class="flex-grow pt-34 px-8 ">
        @yield('content')
    </main>


    <footer>
        @include('template.partials.footer')
    </footer>

</body>

</html>
@if (Auth::check() && Auth::user()->isAdmin())
    <style>
        @media (max-width: 768px) {

            #main-header {
                height: auto;
            }

            main {
                padding-top: calc(50px + 0.5rem);
            }

            #navbar {
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                padding: 0;
            }

            .navbar-item {
                padding: 0 5px;
                font-size: 12px;
            }

            header a,
            #navbar a {
                padding: 5px 0;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {

            #main-header {
                height: auto;
                padding: 0;
            }

            #main-header .container,
            #navbar .container {
                max-width: 100%;
                padding: 0 15px;
            }

            main {
                padding-top: calc(60px + 0.5rem);
            }

            #navbar {
                padding: 0;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                width: 100%;
            }

            .navbar-item {
                padding: 0 8px;
                font-size: 14px;
            }

            header a,
            #navbar a {
                padding: 8px 0;
                font-size: 14px;
            }

            .carousel-inner img {
                max-height: 300px;
                object-fit: cover;
            }

            .container {
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }
        }

        @media (min-width: 800px) and (max-width: 840px) and (min-height: 1100px) and (max-height: 1200px) {

            #main-header {
                height: auto;
                padding: 0;
            }

            main {
                padding-top: calc(80px + 0.5rem);
            }

            #navbar {
                padding: 0;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                width: 100%;
            }

            .navbar-item {
                padding: 0 10px;
                font-size: 14px;
            }

            header a,
            #navbar a {
                padding: 8px 0;
                font-size: 14px;
            }

            .container {
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }

            .carousel-inner img {
                max-height: 300px;
                object-fit: cover;
            }
        }
    </style>
@else
    <style>
        @media (max-width: 768px) {


            #main-header {
                height: auto;
            }

            main {
                padding-top: calc(100px + 1rem);
            }

            #navbar {
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                padding: 0;

            }

            .navbar-item {
                padding: 0 5px;
                font-size: 12px;
            }

            header a,
            #navbar a {
                padding: 5px 0;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {

            #main-header {
                height: auto;
                padding: 0;
            }

            #main-header .container,
            #navbar .container {
                max-width: 100%;
                padding: 0 15px;
            }

            main {
                padding-top: calc(80px + 1rem);
            }

            #navbar {
                padding: 0;
                /* Eliminar padding lateral */
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                width: 100%;
            }

            .navbar-item {
                padding: 0 8px;
                font-size: 14px;
            }

            header a,
            #navbar a {
                padding: 8px 0;
                font-size: 14px;
            }

            .carousel-inner img {
                max-height: 300px;
                object-fit: cover;
            }

            .container {
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }
        }

        @media (min-width: 800px) and (max-width: 840px) and (min-height: 1100px) and (max-height: 1200px) {

            #main-header {
                height: auto;
                padding: 0;
            }

            main {
                padding-top: calc(120px + 1rem);
            }

            #navbar {
                padding: 0;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                width: 100%;
            }

            .navbar-item {
                padding: 0 10px;
                font-size: 14px;
            }

            header a,
            #navbar a {
                padding: 8px 0;
                font-size: 14px;
            }

            .container {
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }

            .carousel-inner img {
                max-height: 300px;
                object-fit: cover;
            }
        }
    </style>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let lastScrollTop = 0;
        const mainHeader = document.getElementById('main-header');

        window.addEventListener("scroll", function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                // Scroll hacia abajo - ocultar header
                mainHeader.classList.add('-translate-y-full');
            } else {
                // Scroll hacia arriba - mostrar header
                mainHeader.classList.remove('-translate-y-full');
            }
            lastScrollTop = scrollTop;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ageYesButton = document.getElementById('age-yes');
        var ageNoButton = document.getElementById('age-no');
        var modal = document.getElementById('age-verification-modal');

        if (modal) {
            if (!document.cookie.split('; ').find(row => row.startsWith('age_verified=true'))) {
                modal.style.display = 'flex';
            } else {
                modal.style.display = 'none';
            }

            if (ageYesButton) {
                ageYesButton.addEventListener('click', function() {
                    document.cookie = "age_verified=true; max-age=" + 60 * 60 * 24 * 30 + "; path=/";
                    modal.style.display = 'none';
                });
            }

            if (ageNoButton) {
                ageNoButton.addEventListener('click', function() {
                    window.location.href = 'https://www.google.com';
                });
            }
        }
    });
</script>
