<div>
    <ol class="flex items-center justify-center space-x-4 mt-4 w-full">
        <li class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400">
                <span class="font-medium">Dados Pessoais</span>
            </button>
        </li>
        <div class="w-10 h-0.5 bg-green-300 dark:bg-green-800"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400">
                <span class="font-medium">Dados Acadêmicos</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-green-300 dark:bg-green-800"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400">
                <span class="font-medium">Escolha</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-gray-300 dark:bg-gray-700"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400">
                <span class="font-medium">Motivação/Documentos</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-gray-300 dark:bg-gray-700"></div>
        <div class="flex items-center space-x-2">
            <button class="p-4 text-green-700 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:border-green-800 dark:text-green-400">
                <span class="font-medium">Status das Cartas</span>
            </button>
        </div>
        <div class="w-10 h-0.5 bg-gray-300 dark:bg-gray-700"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="flex items-center space-x-2">
                <button class="p-4 text-red-700 border border-red-300 rounded-lg bg-red-200 dark:bg-red-800 dark:border-red-800 dark:text-red-400">
                    <a href="{{ route('logout') }}"  onclick="event.preventDefault();this.closest('form').submit();">
                        <span class="font-medium">Sair</span>
                    </a>
                </button>
            </div>
        </form>
    </ol>
</div>
@yield('dados_pessoais')


@include('layouts.rodape')
