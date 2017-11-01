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
    
    <hr>
    <h3>Dados Acadêmicos</h3>
    <div>
    	<label>Graduação: </label> {{ $dados_candidato_para_relatorio['curso_graduacao'] }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>Tipo: </label> {{ $dados_candidato_para_relatorio['tipo_curso_graduacao'] }}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<label>Instituição: </label> {{ $dados_candidato_para_relatorio['instituicao_graduacao'] }}
    </div>
    <div>
    	<label>Ano de Conclusão (ou previsão): </label> {{ $dados_candidato_para_relatorio['ano_conclusao_graduacao'] }}
    </div>
    @if ($dados_candidato_para_relatorio['curso_pos'])
    	<hr size="0">
    	<div>
    		<label>Pós-Graduação: </label> {{ $dados_candidato_para_relatorio['curso_pos'] }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>Tipo: </label> {{ $dados_candidato_para_relatorio['tipo_curso_pos'] }}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<label>Instituição: </label> {{ $dados_candidato_para_relatorio['instituicao_pos'] }}
    	</div>
    	<div>
    		<label>Ano de Conclusão (ou previsão): </label> {{ $dados_candidato_para_relatorio['ano_conclusao_pos'] }}
    	</div>
    @endif
    
    <hr>
    <h3>Programa pretendido</h3>
    <div>
    	<label>Programa pretendido: </label>{{ $dados_candidato_para_relatorio['programa_pretendido'] }} {!! $dados_candidato_para_relatorio['area_pos'] ? '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<label> Área: </label>'.$dados_candidato_para_relatorio['area_pos']: '' !!}
    </div>
    <div>
    	<label>Interesse em bolsa: </label> {{ $dados_candidato_para_relatorio['interesse_bolsa'] ? 'Sim' : 'Não' }}
    </div>
    <div>
    	<label>Possui vínculo empregatício: </label> {{ $dados_candidato_para_relatorio['vinculo_empregaticio'] ? 'Sim' : 'Não' }}
    </div>
</body>

</html>