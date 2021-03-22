<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscrições Pós Graduação MAT/UnB</title>

    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </head>
    
    <body class="bg-gray-100">
        
        {{-- header --}}
        <div class="bg-azul-MAT p-4 flex lg:justify-center md:justify-between items-center">
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
´
        </div>

        {{-- Language area --}}

        <div id="main" class="p-4 lg:justify-center lg:space-x-14 md:justify-around ml-2 h-26 w-3/3 flex items-stretch">
            <div class="bg-azul-MAT rounded-full py-2 w-32 hover:bg-blue-700 text-center text-white"><a href="#">Português</a></div>
            <div class="bg-azul-MAT rounded-full py-2 w-32 hover:bg-blue-700 text-center text-white"><a href="#">English</a></div>
            <div class="bg-azul-MAT rounded-full py-2 w-32 hover:bg-blue-700 text-center text-white"><a href="#">Español</a></div>
        </div>
        {{-- main area --}}

        <div id="main" class="p-16 lg:justify-center lg:space-x-14 md:justify-around ml-2 h-26 w-3/3 flex items-stretch">
            <div class="bg-verde-MAT rounded-lg py-2 w-72 hover:bg-blue-700 text-center text-white"><a href="#">Login</a></div>
            <div class="bg-blue-700 rounded-lg py-2 w-72 hover:bg-blue-800 text-center text-white"><a href="#">Registrar</a></div>
        </div>

        <div id="main" class="lg:justify-center lg:space-x-14 md:justify-around ml-2 w-3/3 flex items-stretch">
            <div class="hover:underline text-center text-blue-600"><a href="#">Esqueceu a senha?</a></div>
        </div>

        @yield('content')
        
        {{-- footer --}}
            <p>Pós-Graduação MAT/UnB - {{ date("Y") }}  - <a href="mailto:posgrad@mat.unb.br">{{ trans('mensagens_gerais.duvidas_pos') }}</a> - <a href="mailto:informatica@mat.unb.br">{{ trans('mensagens_gerais.problemas') }}</a></p>

        
    </body>
</html>