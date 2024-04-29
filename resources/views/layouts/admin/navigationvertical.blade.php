<!-- component -->
<div class="w-full bg-white shadow-xl rounded-lg flex overflow-x-auto custom-scrollbar">
    <div class="w-64 px-4">
        <div class="px-2 pt-4 pb-8 border-r border-gray-300">
            <ul class="space-y-2">
                <li>
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <a id="dropdownHoverButton" class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <span class="flex items-center space-x-2">
                                    Sistema
                                </span>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </a>
                        </x-slot>
                        <x-slot name="content">
                            
                        </x-slot>
                    </x-dropdownadmin>
                </li>
                <li>
                    <x-dropdownadmin align="left" width="48">
                        <x-slot name="trigger">
                            <a id="dropdownHoverButton" class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <span class="flex items-center space-x-2">
                                    Configurar Inscrição
                                </span>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </a>
                        </x-slot>
                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Sair1
                            </x-dropdown-link>
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Sair2
                            </x-dropdown-link>
                        </form>
                        </x-slot>
                    </x-dropdownadmin>
                </li>
                <li>
                    <div class="mt-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Sair
                            </x-dropdown-link>
                        </form>
                </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex-1 px-2" x-data="{ checkAll: false, filterMessages: false }">
        <div class="h-16 flex items-center justify-between">
            <div class="flex items-center">
                asfajflaskjfd
            </div>
        </div>
    </div>
</div>