@extends('layouts.app')


@section('editar_inscricao')
    <div class="max-w-4xl mx-auto bg-white rounded p-6 shadow-md">
    	<x-alerta />
        <h2 class="text-2xl font-semibold mb-4">Editar os dados da inscrição vigente</h2>
         <form class="grid grid-cols-2 gap-4" method="POST" action="{{ route('editar.inscricao')}}" enctype="multipart/form-data">
    		@csrf
            <div>
                <div class="mb-4">
                	<input type="hidden" name="id_inscricao_pos" value="{{ $edital_vigente->id }}">
                    <label for="inicio_inscricao" class="block text-gray-700 font-semibold mb-2">Início da inscrição:</label>
                    <input type="text" id="inicio_inscricao" name="inicio_inscricao" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->inicio_inscricao }}">
                </div>
                <div class="mb-4">
                    <label for="prazo_carta" class="block text-gray-700 font-semibold mb-2">Prazo da carta:</label>
                    <input type="text" id="prazo_carta" name="prazo_carta" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->prazo_carta }}">
                </div>
                <div class="mb-4">
                    <label for="data_divulgacao_resultado" class="block text-gray-700 font-semibold mb-2">Data da divulgação do resultado:</label>
                    <input type="tel" id="data_divulgacao_resultado" name="data_divulgacao_resultado" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->data_divulgacao_resultado }}">
                </div>
                <div class="mb-4">
                    <label for="edital" class="block text-gray-700 font-semibold mb-2">Edital:</label>
                    <input type="text" id="edital" name="edital" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->edital }}">
                </div>
                <div class="mb-4">
                    <label for="necessita_semestre_inicio" class="block text-gray-700 font-semibold mb-2">Necessita semestre de início?</label>
                    <input type="text" id="necessita_semestre_inicio" name="necessita_semestre_inicio" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->necessita_semestre_inicio ? 'Sim' : 'Não' }}">
                </div>

            </div>
            <div>
                <div class="mb-4">
                    <label for="fim_inscricao" class="block text-gray-700 font-semibold mb-2">Fim da inscrição:</label>
                    <input type="text" id="fim_inscricao" name="fim_inscricao" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->fim_inscricao }}">
                </div>
                <div class="mb-4">
                    <label for="data_homologacao" class="block text-gray-700 font-semibold mb-2">Data da homologação:</label>
                    <input type="text" id="data_homologacao" name="data_homologacao" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->data_homologacao }}">
                </div>
                <div class="mb-4">
                    <label for="programa" class="block text-gray-700 font-semibold mb-2">Programas para inscrição:</label>
                    <input type="text" id="programa" name="programa" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->programa }}">
                </div>
                <div class="mb-4">
                    <label for="necessita_recomendante" class="block text-gray-700 font-semibold mb-2">Necessita de recomendante?</label>
                    <input type="text" id="necessita_recomendante" name="necessita_recomendante" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->necessita_recomendante ? 'Sim' : 'Não' }}">
                </div>
                <div class="mb-4">
                    <label for="semestre_inicio" class="block text-gray-700 font-semibold mb-2">Semestre de Início:</label>
                    <input type="text" id="semestre_inicio" name="semestre_inicio" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500" value="{{ $edital_vigente->semestre_inicio }}">
                </div>
            </div>
            <div class="col-span-2 mt-6 flex justify-center">
                <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Salvar</button>
            </div>
        </form>
    </div>
@endsection