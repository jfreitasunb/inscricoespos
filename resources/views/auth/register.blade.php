@extends('layouts.app')

@section('inicio')
<div class="mt-24 flex-col justify-center font-[sans-serif] text-[#333] sm:h-screen p-4">
    <div class="max-w-md w-full mx-auto border border-gray-300 rounded-md p-6">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <x-input-label for="nome" :value="__('tela_registro.menu_nome')" />
                    <x-text-input id="nome" class="block mt-1 w-1/2" type="text" name="nome" :value="old('nome')" required autofocus autocomplete="nome" />
                    <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('tela_registro.menu_email')" />
                    <x-text-input id="email" class="block mt-1 w-1/2" type="email" name="email" :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Confirm Email -->
                <div class="mt-4">
                    <x-input-label for="email_confirmation" :value="__('tela_registro.menu_confirma_email')" />

                    <x-text-input id="email_confirmation" class="block mt-1 w-1/2"
                                    type="email"
                                    name="email_confirmation" required autocomplete="email" />

                    <x-input-error :messages="$errors->get('email_confirmation')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('tela_registro.menu_senha')" />

                    <x-text-input id="password" class="block mt-1 w-1/2"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('tela_registro.menu_confirma_senha')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-1/2"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="!mt-10">
                <x-primary-button>
                    {{ __('tela_registro.menu_registro') }}
                </x-primary-button>
            </div>

            <div class="!mt-10">
                <p class="text-sm mt-6 text-center"><a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline ml-1">{{ __('tela_registro.ja_possui_conta') }}</a></p>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
