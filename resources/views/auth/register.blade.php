@extends('layouts.app')

@section('inicio')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="nome" :value="__('tela_registro.menu_nome')" />
            <x-text-input id="nome" class="block mt-1 w-1/2" type="text" name="nome" :value="old('nome')" required autofocus autocomplete="nome" />
            <x-input-error :messages="$errors->get('nome')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('tela_registro.menu_email')" />
            <x-text-input id="email" class="block mt-1 w-1/2" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Confirm Email -->
        <div class="mt-4">
            <x-input-label for="email_confirmation" :value="__('tela_registro.menu_confirma_email')" />

            <x-text-input id="email_confirmation" class="block mt-1 w-1/2"
                            type="email"
                            name="email_confirmation" required autocomplete="username" />

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

        <div class="flex items-center justify-left mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('tela_registro.ja_possui_conta') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('tela_registro.menu_registro') }}
            </x-primary-button>
        </div>
    </form>
@endsection
