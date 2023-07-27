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
    <body class="min-h-screen flex flex-col items-center justify-center">
        <!-- Cabeçalho -->
     <div class="h-32 md:h-48 w-screen bg-azul-MAT md:flex-col">
        <!-- Header com flex -->
        <header class="flex">
            <!-- Div com tamanho w-1/5 e imagem -->
            <div class="p-4 flex items-start justify-left md:justify-center md:flex-col md:items-center md:text-center">
                <a href="{{URL::to('/')}}"> <img src="{{ asset('imagens/logo/logo_unb.png') }}" alt="Logo do MAT-UnB" class="w-16 md:w-full" style="height:120px" /></a>
            </div>
            <!-- Div com tamanho w-5/6 e texto em três parágrafos -->
            <div class="p-4 flex flex-col md:ml-72 md:text-center">
                <!-- Conteúdo da segunda div -->
                <h1 class="text-white md:text-5xl">Departamento de Matemática</h1>
                <h2 class="text-white md:text-5xl">Inscrições para o Mestrado e Doutorado</h2>
                <h3 class="text-white md:text-5xl">22/11/2022 à 22/01/2023</h3>
            </div>
        </header>
    </div>
    <!-- Corpo -->
    <main class="container mx-auto px-4 flex-grow">
        <div class="flex justify-center items-center mt-12">
                <div class="grid grid-cols-3 gap-4">
                    <div class="mt-4">
                        <button type="button" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            Português
                        </button>
                    </div>
                    <div class="mt-4 pl-2">
                        <button type="button" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            English
                        </button>
                    </div>
                    <div class="mt-4 pl-2">
                        <button type="button" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            Español
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center mt-12 lg:mt-44">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-4 sm:pl-4">
                        <button type="button" class="w-full bg-verde-MAT text-white border border-bg-azul-MAT hover:bg-green-700 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">
                            Login
                        </button>
                    </div>
                    <div class="mt-4 sm:pl-4">
                        <button type="button" class="bg-azul-MAT text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">
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

    <!-- Rodapé -->
    <footer class="py-4 text-center fixed bottom-0 w-full">
        <hr class="my-8">
        <p class="pl-4 text-center">Pós-Graduação MAT/UnB - {{ date("Y") }}</p>
        <p class="pl-4 text-center"><a class="text-blue-500 hover:underline" href="mailto:posgrad@mat.unb.br">{{ trans('mensagens_gerais.duvidas_pos') }}</a></p>
        <p class="pl-4 text-center"><a class="text-blue-500 hover:underline" href="mailto:informatica@mat.unb.br">{{ trans('mensagens_gerais.problemas') }}</a></p>
    </footer>
        @livewireScripts
    </body>
</html>
