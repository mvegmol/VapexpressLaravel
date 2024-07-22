<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vapexpress</title>
    {{-- Favicon  --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon.ico') }}">
    @vite('resources/css/app.css', 'resources/css/app.scss')
</head>

<body class="min-h-screen flex flex-col  text-text_principal ">

    <header id="main-header" class="fixed top-0 left-0 w-full bg-white shadow-lg z-50 transition-transform transform">
        @include('template.partials.header')
        @include('template.partials.navbar')
    </header>
    <div class="pt-36">
        @yield('carousel')
    </div>


    <main class="flex-grow pt-12 px-8">
        @yield('content')
    </main>

    <footer>
        @include('template.partials.footer')
    </footer>
</body>

</html>
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
