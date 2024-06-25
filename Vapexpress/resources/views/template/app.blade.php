<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToysRusUpo</title>
    {{-- Añadir el favicon importante --}}
    {{-- <link rel="icon" type="image/x-icon" href=""> --}}
    @vite('resources/css/app.css', 'resources/css/app.scss')
</head>

<body class="min-h-screen flex flex-col">

    <header>
        @include('partials.navbar')
    </header>

    <main class="flex-grow pt-24">
        @yield('content')
    </main>

    <footer>
        @include('partials.footer')
    </footer>
</body>

</html>
