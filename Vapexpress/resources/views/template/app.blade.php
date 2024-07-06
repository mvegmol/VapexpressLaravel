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

    <header>
        @include('template.partials.header')
        @include('template.partials.navbar')
    </header>

    <main class="flex-grow pt-12 px-8">
        @yield('content')
    </main>

    <footer>
        @include('template.partials.footer')
    </footer>
</body>

</html>
