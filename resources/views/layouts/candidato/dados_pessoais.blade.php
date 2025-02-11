@extends('layouts.app')

@section('dados_pessoais')
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Formulário</h2>
    
    <form action="#" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Nome</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('nome') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">Data de Nascimento</label>
                <input type="date" name="data_nascimento" value="{{ old('data_nascimento') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('data_nascimento') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">Número do RG</label>
                <input type="text" name="rg" value="{{ old('rg') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('rg') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('endereco') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">CEP</label>
                <input type="text" name="cep" value="{{ old('cep') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('cep') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">País</label>
                <select name="pais" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="">Selecione um país</option>
                    <option value="Brasil">Brasil</option>
                    <option value="EUA">EUA</option>
                    <option value="Canadá">Canadá</option>
                    <option value="Portugal">Portugal</option>
                </select>
                @error('pais') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">Estado</label>
                <input type="text" name="estado" value="{{ old('estado') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('estado') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">Cidade</label>
                <input type="text" name="cidade" value="{{ old('cidade') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('cidade') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium">Celular</label>
                <input type="text" name="celular" value="{{ old('celular') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                @error('celular') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="mt-4 flex justify-center space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Salvar</button>
            <button type="button" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Editar</button>
        </div>
    </form>
</div>
@endsection
