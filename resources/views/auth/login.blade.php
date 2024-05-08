@extends('layouts.app')

@section('inicio')
<div class="mt-24 flex-col justify-center font-[sans-serif] text-[#333] sm:h-screen p-4">
    <div class="max-w-md w-full mx-auto border border-gray-300 rounded-md p-6">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-6">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('tela_login.menu_email')" />
                    <x-text-input id="email" class="block mt-1 w-1/2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('tela_login.menu_senha')" />

                    <x-text-input id="password" class="block mt-1 w-1/2"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('tela_login.remember_me') }}</span>
                </label>
            </div>

            <div class="!mt-10">
                <x-primary-button>
                    {{ __('tela_login.menu_entrar') }}
                </x-primary-button>
            </div>

            @if (Route::has('password.request'))
                <p class="text-sm mt-6 text-center"><a class="text-blue-600 font-semibold hover:underline ml-1" href="{{ route('password.request') }}">
                        {{ __('tela_login.menu_esqueceu_senha') }}
                    </a>
            @endif
        </form>
    </div>
</div>
@endsection
