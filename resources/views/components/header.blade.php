<div class="flex items-center p-4 bg-azul-MAT lg:justify-center md:justify-between">
    {{-- left side --}}
    <div class="lg:w-1/3 md:w-1/2">
        <a href="{{ URL::to('/') }}"><img src="{{ asset('imagens/logo/logo_unb.png') }}" width="140" alt="Logo"></a>
    </div>

    {{-- right side --}}

    <div class="ml-2 lg:w-2/3 lg:self-center md:w-1/2 lg:mr-96">
        <h1 class="text-white lg:text-6xl md:text-4xl md:text-center lg:mb-4">{{ __('mensagens_gerais.departamento') }}</h1>
        <h2 class="text-white lg:text-4xl md:text-2xl md:text-center lg:mb-4">{{ __('mensagens_gerais.'.$texto_inscricao_pos) }}</h2>
        <h3 class="text-white lg:text-2xl md:text-2xl md:text-center lg:mb-4">{{ $periodo_inscricao }}</h3>
    </div>
    <div></div>
</div>
