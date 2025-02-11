<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="min-h-screen flex flex-col items-center justify-center">
        {{-- Cabeçalho --}}
        @include('layouts.cabecalho')
        <!-- Corpo -->
        <main class="container mx-auto px-4 flex-grow">
            @if (Auth::check())
                @admin(Auth()->user())
                    @include('layouts.admin.menu_admin')
                @endadmin
                @candidato(Auth()->user())
                    @include('layouts.candidato.navigation')
                @endcandidato
            @else
                @yield('inicio')
                @yield('content')
            @endif
        </main>
        @if (Route::current()->getName() == "home")
            @include('layouts.rodape')
        @endif

        @livewireScripts
    </body>
</html>
