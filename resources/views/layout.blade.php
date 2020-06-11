<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ mix('css/app.css')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ mix('js/app.js')}}" defer></script>

    <title>@yield('title','Laravel Aprendible')</title>

   
</head>
<body>

    <div id="app" class="d-flex h-screen flex-column justify-content-between">
        <header>
            @include('partials.nav'){{-- INCLUIMOS LA NAVEGACION --}}

            @include('partials.session-status'){{-- MENSAJES DE SESION --}}
        </header>
    
        <main class="py-4">
            @yield('content')
        </main>

        <footer class="bg-white text-center text-black-50 py-3 shadow">
            {{config('app.name')}} | Copyright &copy; {{date('Y')}}
        </footer>
    </div>

    

</body>
</html>