@extends('layouts.app')

@section('dados_pessoais')
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Formulário</h2>

        <form action="#" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome', $dados['nome'] ?? '') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    @error('nome') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $dados['data_nascimento'] ?? '') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    @error('data_nascimento') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Número do RG</label>
                    <input type="text" name="rg" value="{{ old('rg', $dados['numerorg'] ?? '') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    @error('rg') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Endereço</label>
                    <input type="text" name="endereco" value="{{ old('endereco', $dados['endereco'] ?? '') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    @error('endereco') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">CEP</label>
                    <input type="text" name="cep" value="{{ old('cep', $dados['cep'] ?? '') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    @error('cep') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">País</label>
                    <select name="pais" for="pais" id="pais" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="">Selecione um país</option>
                        @foreach($countries as $key => $country)
                          <option value="{{ $key }}" {{ old('pais', $dados['pais'] ?? '') == $key ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                    @error('pais') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Estado</label>
                    <select name="estado" for="estado" id="estado" value="{{ old('estado') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"></select>
                    @error('estado') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Cidade</label>
                    <select name="cidade" for="cidade" id="cidade" value="{{ old('cidade') }}" required class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"></select>
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
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('post-script')
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        const apiGetStateList = @json(url('api/get-state-list'));
        const apiGetCityList = @json(url('api/get-city-list'));

        function carregarEstados(paisID) {
            if (!paisID) {
                $("#estado, #cidade").empty().append('<option value="">Selecione</option>');
                return;
            }

            $("#estado").html('<option>Carregando...</option>');

            $.ajax({
                type: "GET",
                url: `${apiGetStateList}?country_id=${paisID}`,
                dataType: "json"
            })
            .done(function (res) {
                let options = '<option value="">Selecione</option>';
                $.each(res, function (key, value) {
                    options += `<option value="${key}">${value}</option>`;
                });
                $("#estado").html(options);
                $("#cidade").empty().append('<option value="">Selecione</option>'); // Reseta cidades
            })
            .fail(function () {
                alert("Erro ao carregar estados. Tente novamente.");
                $("#estado").empty().append('<option value="">Selecione</option>');
            });
        }

        function carregarCidades(estadoID) {
            if (!estadoID) {
                $("#cidade").empty().append('<option value="">Selecione</option>');
                return;
            }

            $("#cidade").html('<option>Carregando...</option>');

            $.ajax({
                type: "GET",
                url: `${apiGetCityList}?state_id=${estadoID}`,
                dataType: "json"
            })
            .done(function (res) {
                let options = '<option value="">Selecione</option>';
                $.each(res, function (key, value) {
                    options += `<option value="${key}">${value}</option>`;
                });
                $("#cidade").html(options);
            })
            .fail(function () {
                alert("Erro ao carregar cidades. Tente novamente.");
                $("#cidade").empty().append('<option value="">Selecione</option>');
            });
        }

        // Eventos de mudança
        $("#pais").on("change", function () {
            carregarEstados($(this).val());
        });

        $("#estado").on("change", function () {
            carregarCidades($(this).val());
        });
    });
</script>

@endsection
