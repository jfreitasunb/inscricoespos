@extends('layouts.app')


@section('cadastra_area_pos')
<div class="w-full h-full px-4 py-2 bg-white rounded p-6 shadow-md">
    <x-alerta />
    <form method="POST" action="{{ route('cadastra.area.pos')}}" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center mb-4">
            <label for="nome_ptbr" class="w-1/3 text-right pr-4 font-medium">Nome em Português:</label>
            <input type="text" id="nome_ptbr" name="nome_ptbr" class="w-2/3 p-2 border border-gray-300 rounded-lg">
        </div>

        <div class="flex items-center mb-4">
            <label for="nome_es" class="w-1/3 text-right pr-4 font-medium">Nome em Espanhol:</label>
            <input type="text" id="nome_es" name="nome_es" class="w-2/3 p-2 border border-gray-300 rounded-lg">
        </div>

        <div class="flex items-center mb-4">
            <label for="nome_en" class="w-1/3 text-right pr-4 font-medium">Nome em Inglês:</label>
            <input type="text" id="nome_en" name="nome_en" class="w-2/3 p-2 border border-gray-300 rounded-lg">
        </div>

        <div class="flex justify-center">  <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">  Enviar
            </button>
        </div>
    </form>
</div>
@endsection
