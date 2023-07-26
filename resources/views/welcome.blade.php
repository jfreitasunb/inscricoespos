<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inscrições Pós-Graduação do MAT/UnB</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            <header>
                <div class="bg-azul-MAT lg:flex flex-grow lg:items-center p-8 sm:p-12">
                    <div class="flex-grow">
                        <a href="{{URL::to('/')}}"> <img src="{{ asset('imagens/logo/logo_unb.png') }}" alt="Logo do MAT-UnB" class="sm:flex-shrink-0 mx-auto sm:mx-0 h-24" style="height:120px" /></a>
                        <div class="xm:ml-4 sm:text-left text-center">
                            <h1 class="text-white text-center text-2xl sm:text-5xl mb-2">Departamento de Matemática</h1>
                            <h2 class="text-white text-center text-2xl sm:text-5xl mb-2">Inscrições para o Mestrado e Doutorado</h2>
                            <h3 class="text-white text-center text-2xl sm:text-5xl mb-2">22/11/2022 à 22/01/2023</h3>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex justify-center items-center mt-12">
                <div class="grid grid-cols-3 gap-4">
                    <div class="mt-4">
                        <button type="button" class="bg-azul-MAT text-white hover:text-white border border-azul-MAT bg-violet-500 hover:bg-violet-600 active:bg-violet-700 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            Português
                        </button>
                    </div>
                    <div class="mt-4 pl-2">
                        <button type="button" class="bg-azul-MAT text-white hover:text-white border border-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            English
                        </button>
                    </div>
                    <div class="mt-4 pl-2">
                        <button type="button" class="bg-azul-MAT text-white hover:text-white border border-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            Español
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center mt-12 lg:mt-44">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-4 sm:pl-4">
                        <button type="button" class="w-full bg-verde-MAT text-white border border-azul-MAT hover:bg-green-700 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">
                            Login
                        </button>
                    </div>
                    <div class="mt-4 sm:pl-4">
                        <button type="button" class="bg-azul-MAT text-white border border-azul-MAT hover:bg-sky-900 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">
                            Registrar
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center mt-8">
                <div class="flex items-center mt-4">
                    <p class="items-center text-blue-500 hover:underline"><a href="#">Esqueceu a senha?</a>
                </div>
            </div>
        </div>

        <footer id="footer" class="sticky top-[80vh] lg:mt-52">
            <hr class="my-8 h-px">
            <div class="relative flex justify-center">
                <p class="pl-4 text-center">Pós-Graduação MAT/UnB - {{ date("Y") }}  - <a class="text-blue-500 hover:underline" href="mailto:posgrad@mat.unb.br">{{ trans('mensagens_gerais.duvidas_pos') }}</a> - <a class="text-blue-500 hover:underline" href="mailto:informatica@mat.unb.br">{{ trans('mensagens_gerais.problemas') }}</a></p>
            </div>
        </footer>
        @livewireScripts
    </body>
</html>
