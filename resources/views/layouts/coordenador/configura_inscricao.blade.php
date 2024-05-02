@extends('layouts.app')


@section('configura_inscricao')
<div class="max-w-2xl mx-auto">
    <form method="POST" action="{{ route('configura.inscricao')}}">
    @csrf
    <!-- Seção: Datas importantes -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Datas Importantes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="inicio_inscricao" class="block mb-1">Início da Inscrição</label>
                <input type="date" id="inicio_inscricao" name="inicio_inscricao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('inicio_inscricao') }}" required>
                @if($errors->has('inicio_inscricao'))
                    <div id="alert-1" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ $errors->first('inicio_inscricao') }}
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-1" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <div>
                <label for="fim_inscricao" class="block mb-1">Final da Inscrição</label>
                <input type="date" id="fim_inscricao" name="fim_inscricao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('fim_inscricao') }}" required>
                @if($errors->has('fim_inscricao'))
                    <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ $errors->first('fim_inscricao') }}
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <div>
                <label for="prazo_carta" class="block mb-1">Prazo para Envio da Carta</label>
                <input type="date" id="prazo_carta" name="prazo_carta" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('prazo_carta') }}" required>
                @if($errors->has('prazo_carta'))
                    <div id="alert-3" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ $errors->first('prazo_carta') }}
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <div>
                <label for="data_homologacao" class="block mb-1">Data da Homologação das Inscrições</label>
                <input type="date" id="data_homologacao" name="data_homologacao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('data_homologacao') }}" required>
                @if($errors->has('data_homologacao'))
                    <div id="alert-4" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ $errors->first('data_homologacao') }}
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-4" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <div>
                <label for="data_divulgacao_resultado" class="block mb-1">Data da Divulgação do Resultado</label>
                <input type="date" id="data_divulgacao_resultado" name="data_divulgacao_resultado" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('data_divulgacao_resultado') }}" required>
                @if($errors->has('data_divulgacao_resultado'))
                    <div id="alert-5" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ $errors->first('data_divulgacao_resultado') }}
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-5" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <div>
                <label for="semestre_inicio" class="block mb-1">Ano e Semestre de Início no Programa</label>
                <input type="text" id="semestre_inicio" name="semestre_inicio" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('semestre_inicio') }}">
            </div>
        </div>
    </div>

    <!-- Seção: Escolha de Programas -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Escolha de Programas</h2>
        <div class="flex flex-wrap gap-4">
            @foreach($programas_pos_mat as $programa)
                <label for="escolhas_coordenador[]" class="inline-flex items-center">
                    <input type="checkbox" id="escolhas_coordenador[]" name="escolhas_coordenador[]" class="mr-2" value="{{ $programa->id }}"> {{ $programa->tipo_programa_pos_ptbr }}
                </label>
            @endforeach
        </div>
    </div>

    <!-- Seção: Recomendante -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Recomendante</h2>
        <div class="flex items-center gap-4">
            <label for="necessita_recomendante" class="inline-flex items-center">
                <input type="radio" id="necessita_recomendante" name="necessita_recomendante" class="mr-2"value="1" checked> Sim
            </label>
            <label for="necessita_recomendante" class="inline-flex items-center">
                <input type="radio" id="necessita_recomendante" name="necessita_recomendante" class="mr-2" value="0"> Não
            </label>
        </div>
    </div>

    <!-- Seção: Outros Detalhes -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Ano e número do edital</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="edital_ano" class="block mb-1">Ano</label>
                <input type="text" id="edital_ano" name="edital_ano" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="edital_numero" class="block mb-1">Número</label>
                <input type="text" id="edital_numero" name="edital_numero" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
            </div>
        </div>
    </div>

    <!-- Seção: Envio de Arquivos -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Envio de Arquivos</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <div>
                <label for="edital_portugues" class="block mb-1">Edital em Português</label>
                <input type="file" accept="application/pdf" id="edital_portugues" name="edital_portugues" class="w-full" required>
            </div>
            <div>
                <label for="edital_ingles" class="block mb-1">Edital em Inglês</label>
                <input type="file" accept="application/pdf" id="edital_ingles" name="edital_ingles" class="w-full">
            </div>
            <div>
                <label for="edital_espanhol" class="block mb-1">Edital em Espanhol</label>
                <input type="file" accept="application/pdf" id="edital_espanhol" name="edital_espanhol" class="w-full">
            </div>
        </div>
    </div>

    <!-- Botão de Submissão -->
    <div class="text-center">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Enviar</button>
    </div>
    </form>
</div>

@endsection
