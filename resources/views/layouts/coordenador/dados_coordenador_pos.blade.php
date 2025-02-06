@extends('layouts.app')


@section('dados_coordenador_pos')
<div class="w-full h-full px-4 py-2 bg-white rounded p-6 shadow-md">
    <x-alerta />
    <form method="POST" action="{{ route('dados.coordenador.pos')}}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4 flex items-center">
            <label for="nome_coordenador" class="text-gray-700 font-semibold mr-2">Nome do(a) Coordenador(a):</label>
            <input type="text" id="nome_coordenador" name="nome_coordenador" class="w-1/2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Digite seu nome" required>
        </div>

        <div class="mb-4 flex items-center">
            <legend class="text-gray-700 font-semibold">Forma de Tratamento:</legend>
            <div class="flex items-center space-x-4 mx-3">
                <div class="flex items-center">
                    <input type="radio" id="prof_tratamento" name="prof_tratamento" value="Prof." class="mr-1" required>
                    <label for="prof_tratamento" class="text-gray-700">Prof.</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" id="prof_tratamento" name="prof_tratamento" value="Profa." class="mr-1">
                    <label for="prof_tratamento" class="text-gray-700">Profa.</label>
                </div>
            </div>
        </div>

        <div class="mb-4 flex items-center">
            <legend class="text-gray-700 font-semibold">Tipo:</legend>
            <div class="flex items-center space-x-4 mx-3">
                <div class="flex items-center">
                    <input type="radio" id="tipo_coord" name="tipo_coord" value="Coordenador" class="mr-1" required>
                    <label for="tipo_coord" class="text-gray-700">Coordenador</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" id="tipo_coord" name="tipo_coord" value="Coordenadora" class="mr-1">
                    <label for="tipo_coord" class="text-gray-700">Coordenadora</label>
                </div>
            </div>
        </div>
        <div class="flex justify-center">  <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">  Enviar
            </button>
        </div>
    </form>
</div>
@endsection
