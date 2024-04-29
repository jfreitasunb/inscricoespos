@extends('layouts.app')

@section('inicio')
    <div class="flex justify-center items-center mt-12">
                <div class="grid grid-cols-3 gap-4">
                    <div class="mt-4">
                        <a href="{{ route('lang.portuguese') }}" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            Português
                        </a>
                    </div>
                    <div class="mt-4 pl-2">
                        <a href="{{ route('lang.english') }}" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            English
                        </a>
                    </div>
                    <div class="mt-4 pl-2">
                        <a href="{{ route('lang.spanish') }}" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
                            Español
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center mt-12 lg:mt-44">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-4 sm:pl-4">
                        <a href="{{ route('login') }}" class="w-full bg-verde-MAT text-white border border-bg-azul-MAT hover:bg-green-700 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">{{ __('tela_inicial.menu_login') }}
                        </a>
                    </div>
                    <div class="mt-4 sm:pl-4">
                        <a  href="{{ route('register') }}" class="bg-azul-MAT text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">{{ __('tela_inicial.menu_registrar') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center mt-8">
                <div class="flex items-center mt-4">
                    <p class="items-center text-blue-500 hover:underline"><a href="{{ route('password.request') }}">{{ __('tela_login.menu_esqueceu_senha') }}</a></p>
                </div>
            </div>
@endsection
