@extends('layouts.app')


@section('configura_inscricao')
<form method="POST" action="{{ route('configura.inscricao')}}">
    @csrf
<div class="max-w-2xl mx-auto">
    <!-- Seção: Datas importantes -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Datas Importantes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="inicio_inscricao" class="block mb-1">Início da Inscrição</label>
                <input type="date" id="inicio_inscricao" name="inicio_inscricao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="final_inscricao" class="block mb-1">Final da Inscrição</label>
                <input type="date" id="final_inscricao" name="final_inscricao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="prazo_carta" class="block mb-1">Prazo para Envio da Carta</label>
                <input type="date" id="prazo_carta" name="prazo_carta" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="data_homologacao" class="block mb-1">Data da Homologação das Inscrições</label>
                <input type="date" id="data_homologacao" name="data_homologacao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="data_divulgacao_resultado" class="block mb-1">Data da Divulgação do Resultado</label>
                <input type="date" id="data_divulgacao_resultado" name="data_divulgacao_resultado" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="semestre_inicio" class="block mb-1">Ano e Semestre de Início no Programa</label>
                <input type="text" id="semestre_inicio" name="semestre_inicio" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- Seção: Escolha de Programas -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Escolha de Programas</h2>
        <div class="flex flex-wrap gap-4">
            <label for="programa1" class="inline-flex items-center">
                <input type="checkbox" id="programa1" name="programa1" class="mr-2"> Programa 1
            </label>
            <label for="programa2" class="inline-flex items-center">
                <input type="checkbox" id="programa2" name="programa2" class="mr-2"> Programa 2
            </label>
        </div>
    </div>

    <!-- Seção: Recomendante -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Recomendante</h2>
        <div class="flex items-center gap-4">
            <label for="recomendante" class="inline-flex items-center">
                <input type="radio" id="recomendante" name="recomendante" class="mr-2"> Sim
            </label>
            <label for="sem-recomendante" class="inline-flex items-center">
                <input type="radio" id="sem-recomendante" name="recomendante" class="mr-2"> Não
            </label>
        </div>
    </div>

    <!-- Seção: Outros Detalhes -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Outros Detalhes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="ano-selecionado" class="block mb-1">Ano Selecionado</label>
                <input type="text" id="ano-selecionado" name="ano-selecionado" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="numero-informado" class="block mb-1">Número Informado</label>
                <input type="text" id="numero-informado" name="numero-informado" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- Seção: Envio de Arquivos -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Envio de Arquivos</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="arquivo1" class="block mb-1">Arquivo 1</label>
                <input type="file" id="arquivo1" name="arquivo1" class="w-full">
            </div>
            <div>
                <label for="arquivo2" class="block mb-1">Arquivo 2</label>
                <input type="file" id="arquivo2" name="arquivo2" class="w-full">
            </div>
            <div>
                <label for="arquivo3" class="block mb-1">Arquivo 3</label>
                <input type="file" id="arquivo3" name="arquivo3" class="w-full">
            </div>
        </div>
    </div>

    <!-- Botão de Submissão -->
    <div class="text-center">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Enviar</button>
    </div>
</div>
</form>
@endsection
