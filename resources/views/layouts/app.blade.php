<!DOCTYPE html>
<html lang="pt_br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscrições Pós Graduação MAT/UnB</title>

    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </head>
    
    <body>
        
        {{-- header --}}
        <div class="bg-azul-MAT p-4">
            {{-- left side --}}
            <div class="flex justify-between items-center">
                <img src="{{ asset('imagens/logo/logo_unb.png') }}" width="120" alt="Logo" class="mr-2">
                <p class="text-indigo-50">Departamento de Matemática</p>
                <p>Inscrições para o Mestrado e Doutorado</p>
                <p>01/01/2021 à 31/12/2021</p>
            </div>

            {{-- right side --}}

        </div>
        {{-- main area --}}

        {{-- footer --}}
            @yield('content')
        
    </body>
</html>