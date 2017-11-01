<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        h2 {text-align:center;}
        label {font-weight: bold;}
    </style>
</head>

<body>
    <h2>Ficha de Inscrição - {{ $dados_candidato_para_relatorio['programa_pretendido'] }} {{ $dados_candidato_para_relatorio['area_pos'] ? ' - '.$dados_candidato_para_relatorio['area_pos']: '' }}</h2>
    <div>
        <label class="control-label">Nome: </label>{{ $dados_candidato_para_relatorio['nome'] }}
    </div>
    <div>
        <label class="control-label">Data de nascimento: </label>{{ $dados_candidato_para_relatorio['data_nascimento'] }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <label class="control-label">Idade: </label>{{ $dados_candidato_para_relatorio['idade'].' anos' }}
    </div>
    <hr>
    <h3>Endereço Pessoal</h3>
    <div>
    	<label>Endereço: </label>{{ $dados_candidato_para_relatorio['endereco'] }}
    </div>
    <div>
    	<label>Celular: </label>{{ $dados_candidato_para_relatorio['celular'] }}
    </div>
    <div>
    	<label>País: </label> {{ $dados_candidato_para_relatorio['nome_pais'] }}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label> Estado: </label>{{ $dados_candidato_para_relatorio['nome_estado'] }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>Cidade: </label> {{ $dados_candidato_para_relatorio['nome_cidade'] }}
    </div>
    
</body>

</html>