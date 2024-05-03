<!-- Cabeçalho -->
<div class="h-32 md:h-48 w-screen bg-azul-MAT md:flex-col">
    <!-- Header com flex -->
    <header class="flex">
        <!-- Div com tamanho w-1/5 e imagem -->
        <div class="p-4 flex items-start justify-left md:justify-center md:flex-col md:items-center md:text-center">
            <a href="{{URL::to('/')}}"> <img src="{{ asset('imagens/logo/logo_unb.png') }}" alt="Logo do MAT-UnB" class="w-16 md:w-full" style="height:120px" /></a>
        </div>
        <!-- Div com tamanho w-5/6 e texto em três parágrafos -->
        <div class="p-4 flex flex-col md:ml-72 md:text-center">
            <!-- Conteúdo da segunda div -->
            <h1 class="text-white md:text-5xl">{{ __('mensagens_gerais.departamento') }}</h1>
            <h2 class="text-white md:text-5xl">{{ __('mensagens_gerais.'.$texto_inscricao_pos) }}</h2>
            <h3 class="text-white md:text-5xl">{{ $periodo_inscricao }}</h3>
        </div>
    </header>
</div>
