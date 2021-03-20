<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscrições Pós Graduação MAT/UnB</title>

    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </head>
    
    <body>
        
        {{-- header --}}
        <div class="bg-azul-MAT p-4 flex mb-4 lg:justify-center md:justify-between">
            {{-- left side --}}
            <div class="lg:w-1/3 md:w-1/2">
                <img src="{{ asset('imagens/logo/logo_unb.png') }}" width="140" alt="Logo">
            </div>

            {{-- right side --}}

            <div class="lg:w-2/3 lg:self-center md:w-1/2 ml-2 lg:mr-96">
                <h1 class="lg:text-6xl md:text-4xl text-white md:text-center lg:mb-4">Departamento de Matemática</h1>
                <h2 class="lg:text-4xl md:text-2xl text-white md:text-center lg:mb-4">Inscrições para o Mestrado e Doutorado</h2>
                <h3 class="lg:text-2xl md:text-2xl text-white md:text-center lg:mb-4">01/01/2021 à 31/12/2021</h3>
            </div>
            <div></div>

        </div>
        {{-- main area --}}

        {{-- footer --}}
            @yield('content')
        
    </body>
</html>