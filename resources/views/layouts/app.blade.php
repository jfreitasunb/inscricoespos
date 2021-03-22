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
        <div class="flex flex-col h-screen justify-between bg-gray-300">
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

            <div id="main" class="lg:justify-center lg:space-x-14 justify-around ml-2 w-3/3 flex items-stretch">
                <a href="#" class="inline-block px-6 bg-azul-MAT rounded-full py-2 w-28 hover:bg-blue-700 text-center text-white">Português</a>
                <a href="#" class="inline-block px-6 bg-azul-MAT rounded-full py-2 w-28 hover:bg-blue-700 text-center text-white">English</a>
                <a href="#" class="inline-block px-6 bg-azul-MAT rounded-full py-2 w-28 hover:bg-blue-700 text-center text-white">Español</a>
            </div>
            {{-- main area --}}

            <div id="main2" class="lg:justify-center lg:space-x-14 justify-around ml-2 w-3/3 flex items-stretch">
                <a href="#" class="inline-block w-28 py-3 px-6 text-lg bg-verde-MAT rounded-lg hover:bg-blue-700 text-center text-white">Login</a>

                <a href="#" class="inline-block w-28 py-3 px-6 text-lg bg-blue-500 rounded-lg hover:bg-blue-700 text-center text-white">Registrar</a>
            </div>

            <div id="main3" class="justify-center lg:space-x-14 md:justify-around ml-2 w-3/3 flex items-stretch">
                <div class="hover:underline text-center text-blue-600"><a href="#">Esqueceu a senha?</a></div>
            </div>

            {{-- footer --}}

            <footer class="justify-center h-14">
                <p class="text-center bg-gray-300">Pós-Graduação MAT/UnB - {{ date("Y") }}  - <a class="hover:underline text-center text-blue-600" href="mailto:posgrad@mat.unb.br">{{ trans('mensagens_gerais.duvidas_pos') }}</a> - <a class="hover:underline text-center text-blue-600" href="mailto:informatica@mat.unb.br">{{ trans('mensagens_gerais.problemas') }}</a></p>
            </footer>
        </div>
    </body>
</html>