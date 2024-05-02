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
                    <div class="error">{{ $errors->first('inicio_inscricao') }}</div>
                @endif
            </div>
            <div>
                <label for="final_inscricao" class="block mb-1">Final da Inscrição</label>
                <input type="date" id="final_inscricao" name="final_inscricao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('final_inscricao') }}" required>
                @if($errors->has('final_inscricao'))
                    <div class="error">{{ $errors->first('final_inscricao') }}</div>
                @endif
            </div>
            <div>
                <label for="prazo_carta" class="block mb-1">Prazo para Envio da Carta</label>
                <input type="date" id="prazo_carta" name="prazo_carta" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('prazo_carta') }}" required>
            </div>
            <div>
                <label for="data_homologacao" class="block mb-1">Data da Homologação das Inscrições</label>
                <input type="date" id="data_homologacao" name="data_homologacao" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('data_homologacao') }}" required>
            </div>
            <div>
                <label for="data_divulgacao_resultado" class="block mb-1">Data da Divulgação do Resultado</label>
                <input type="date" id="data_divulgacao_resultado" name="data_divulgacao_resultado" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('data_divulgacao_resultado') }}" required>
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
