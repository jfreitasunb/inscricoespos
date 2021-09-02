<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscrições Pós Graduação MAT/UnB</title>

    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </head>

    <body>
        <div class="flex flex-col justify-between h-screen bg-gray-300">
            @include('layouts.cabecalho')

            @include('layouts.idiomas')

            @if (Route::currentRouteName() == "home")
                @include('layouts.menu_login_registrar')
            @endif

            @include('layouts.rodape')
        </div>
    </body>
</html>
