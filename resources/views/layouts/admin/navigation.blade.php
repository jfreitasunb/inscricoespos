<div>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto sm:px-6">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Settings Dropdown Sistema -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <x-buttonadmin id="dropdownHoverButton" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-300 hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>Sistema</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-buttonadmin>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Lista/Edita usuários
                                </x-dropdown-link>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Link mudança de senha
                                </x-dropdown-link>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Logar como
                                </x-dropdown-link>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Ativar/alterar conta
                                </x-dropdown-link>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Usuários Inativos
                                </x-dropdown-link>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Associa email de recomendante
                                </x-dropdown-link>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Associações existentes
                                </x-dropdown-link>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Total de cartas por recomendante
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdownadmin>
                </div>

                <!-- Settings Dropdown Dados da INT -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <x-buttonadmin id="dropdownHoverButton" class="inline-flex items-center px-3 py-0 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-300 hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>Dados da INT</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-buttonadmin>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Configurar Inscrição
                                </x-dropdown-link>
                            </form>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Editar Inscrição
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdownadmin>
                </div>

                <!-- Settings Dropdown Configurar Edital -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <x-buttonadmin id="dropdownHoverButton" class="inline-flex items-center px-3 py-0 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-300 hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>Configurar Edital</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-buttonadmin>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Configurar Inscrição
                                </x-dropdown-link>
                            </form>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Editar Inscrição
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdownadmin>
                </div>

                <!-- Settings Dropdown Acompanhar Inscrições -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <x-buttonadmin id="dropdownHoverButton" class="inline-flex items-center px-3 py-0 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-300 hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>Acompanhar Inscrições</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-buttonadmin>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Configurar Inscrição
                                </x-dropdown-link>
                            </form>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Editar Inscrição
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdownadmin>
                </div>

                <!-- Settings Dropdown Gerar Relatórios de Inscritos -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <x-buttonadmin id="dropdownHoverButton" class="inline-flex items-center px-3 py-0 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-300 hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>Gerar Relatórios de Inscritos</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-buttonadmin>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Configurar Inscrição
                                </x-dropdown-link>
                            </form>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Editar Inscrição
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdownadmin>
                </div>

                <!-- Settings Dropdown Processo de Seleção -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <x-buttonadmin id="dropdownHoverButton" class="inline-flex items-center px-3 py-0 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-300 hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>Processo de Seleção</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-buttonadmin>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Configurar Inscrição
                                </x-dropdown-link>
                            </form>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Editar Inscrição
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdownadmin>
                </div>

                <!-- Settings Dropdown Acompanha Selecionados -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <x-buttonadmin id="dropdownHoverButton" class="inline-flex items-center px-3 py-0 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-300 hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>Acompanha Selecionados</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-buttonadmin>
                        </x-slot>

                        <x-slot name="content">

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Configurar Inscrição
                                </x-dropdown-link>
                            </form>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Editar Inscrição
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdownadmin>
                </div>
            </div>

            <!-- Logout -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Sair
                    </x-nav-link>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('menu.admin')" :active="request()->routeIs('menu.admin')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->nome }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
</div>

