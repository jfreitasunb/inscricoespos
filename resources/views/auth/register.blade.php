<x-app-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('registrar') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('tela_registro.menu_nome')" />

                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('tela_registro.menu_email')" />

                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Confirm Email-->
            <div class="mt-4">
                <x-label for="email_confirmation" :value="__('tela_registro.menu_confirma_email')" />

                <x-input id="email_confirmation" class="block w-full mt-1"
                                type="email"
                                name="email_confirmation" required />
            </div>


            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('tela_registro.menu_senha')" />

                <x-input id="password" class="block w-full mt-1"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('tela_registro.menu_confirma_senha')" />

                <x-input id="password_confirmation" class="block w-full mt-1"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('tela_registro.menu_registro_ja_possui_conta') }}
                </a>

                <x-button class="ml-4">
                    {{ __('tela_registro.menu_registro') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>
