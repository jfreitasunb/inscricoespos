<div>
    <ol class="flex flex-wrap items-center justify-center space-x-4 mt-4 w-full md:flex-nowrap md:space-x-4">
        <li class="flex items-center space-x-2">
            <a href="{{ route('dados.pessoais') }}" class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-700">
                <span class="font-medium">Dados Pessoais</span>
            </a>
        </li>
        <div class="w-10 h-0.5 bg-green-300 dark:bg-green-800 hidden md:block"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-700">
                <span class="font-medium">Dados Acadêmicos</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-green-300 dark:bg-green-800 hidden md:block"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-700">
                <span class="font-medium">Escolha</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-gray-300 dark:bg-gray-700 hidden md:block"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-700">
                <span class="font-medium">Motivação/Documentos</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-gray-300 dark:bg-gray-700 hidden md:block"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-700">
                <span class="font-medium">Status das Cartas</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-gray-300 dark:bg-gray-700 hidden md:block"></div>
        <form method="POST" action="{{ route('logout') }}" class="w-full text-center md:w-auto">
            @csrf
            <div class="flex items-center justify-center space-x-2">
                <button class="p-4 text-red-700 border border-red-300 rounded-lg bg-red-200 dark:bg-red-800 dark:border-red-800 dark:text-red-400 hover:bg-red-300 dark:hover:bg-red-700">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                        <span class="font-medium">Sair</span>
                    </a>
                </button>
            </div>
        </form>
    </ol>
</div>
@yield('dados_pessoais')

@include('layouts.rodape')
