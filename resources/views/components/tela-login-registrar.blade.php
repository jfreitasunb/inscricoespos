@if (session('status') == 'verification-link-sent')
    <div class="mb-4 text-sm font-medium text-green-600">
        {{ __('A verification link has been sent to the email address you provided during registration.') }}
    </div>
@endif

<div id="main2" class="flex items-stretch justify-around ml-2 lg:justify-center lg:space-x-14 w-3/3">
    <a href="{{ route('login') }}" class="inline-block px-6 py-3 text-lg text-center text-white rounded-lg w-28 bg-verde-MAT hover:bg-blue-700">Login</a>

    <a href="{{ route('registrar') }}" class="inline-block px-6 py-3 text-lg text-center text-white bg-blue-500 rounded-lg w-28 hover:bg-blue-700">Registrar</a>
</div>

<div id="main3" class="flex items-stretch justify-center ml-2 lg:space-x-14 md:justify-around w-3/3">
    <div class="text-center text-blue-600 hover:underline">
        <a href="{{ route('password.request') }}">{{ __('tela_login.menu_esqueceu_senha') }}</a>
    </div>
</div>
