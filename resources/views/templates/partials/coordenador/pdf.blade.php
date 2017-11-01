<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        h2 {text-align:center;}
        label {font-weight: bold;}
        label.motivacao {font-weight: normal;text-align:justify;}
        .page_break { page-break-before: always;}
        table.tftable {font-size:12px;width:100%;border-width: 1px;border-collapse: collapse;}
		table.tftable th {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;text-align:center;}
		table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;}
        table.tftable td.value {text-align:center;font-weight: bold;font-size:14px;border-width: 1px;padding: 8px;border-style: solid;}
        table.tftable td.cabecalho {text-align:center;font-size:12px;border-width: 1px;padding: 8px;border-style: solid;}
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

    <hr>
    <h3>Dados dos Recomendantes</h3>
    @foreach ($recomendantes_candidato as $recomendante)
    	<div>
    	<label> Nome: </label> {{ $recomendante['nome'] }}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>Email: </label>{{ $recomendante['email'] }}
    </div>
    @endforeach

    <hr>
    <h3>Motivação e expectativa do candidato em relação ao programa pretendido</h3>
    <div>
    	<label class="motivacao">{{ $dados_candidato_para_relatorio['motivacao'] }}</label>
    </div>

    @foreach ($recomendantes_candidato as $recomendante)
    	<div class="page_break"></div>
    	<h3>Carta de Recomendação - {{ $recomendante['nome'] }}</h3>
    	<div>
    		<label>Conhece o candidato há quanto tempo? </label> {{ $recomendante['tempo_conhece_candidato'] }}
    	</div>
    	<div>
    		<label>Conhece o candidato sob as seguintes circunstâncias: </label> {{ $recomendante['circunstancia_1'] }} {{ $recomendante['circunstancia_2'] }} {{ $recomendante['circunstancia_3'] }} {{ $recomendante['circunstancia_4'] }}
    	</div>
    	<div>
    		<label>Conhece o candidato sob outras circunstâncias: </label> {{ $recomendante['circunstancia_outra'] }}
    	</div>
    	<hr size="0">
    	<label>Avaliações</label>

    	<table class="tftable" border="1">
	       <tbody>
        		<tr>
        			<td> </td>
        			<td class="cabecalho">Excelente</td>
        			<td class="cabecalho">Bom</td>
        			<td class="cabecalho">Regular</td>
        			<td class="cabecalho">Insuficiente</td>
        			<td class="cabecalho">Não Sabe</td>
        		</tr>
        		<tr>
        			<td>Desempenho acadêmico</td>
        			<td class="value">{{ $recomendante['desempenho_academico'] == 'Excelente' ? 'X' : '' }}</td>
        			<td class="value">{{ $recomendante['desempenho_academico'] == 'Bom' ? 'X' : '' }}</td>
        			<td class="value">{{ $recomendante['desempenho_academico'] == 'Regular' ? 'X' : '' }}</td>
        			<td class="value">{{ $recomendante['desempenho_academico'] == 'Insuficiente' ? 'X' : '' }}</td>
        			<td class="value">{{ $recomendante['desempenho_academico'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Capacidade de aprender novos conceitos</td>
        			<td class="value">{{ $recomendante['capacidade_aprender'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_aprender'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_aprender'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_aprender'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_aprender'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Capacidade de trabalhar sozinho</td>
        			<td class="value">{{ $recomendante['capacidade_trabalhar'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_trabalhar'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_trabalhar'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_trabalhar'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['capacidade_trabalhar'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Criatividade</td>
        			<td class="value">{{ $recomendante['criatividade'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['criatividade'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['criatividade'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['criatividade'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['criatividade'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Curiosidade</td>
        			<td class="value">{{ $recomendante['curiosidade'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['curiosidade'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['curiosidade'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['curiosidade'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['curiosidade'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Esforço, persistência</td>
        			<td class="value">{{ $recomendante['esforco'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['esforco'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['esforco'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['esforco'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['esforco'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Expressão escrita</td>
        			<td class="value">{{ $recomendante['expressao_escrita'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_escrita'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_escrita'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_escrita'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_escrita'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Expressão oral</td>
        			<td class="value">{{ $recomendante['expressao_oral'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_oral'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_oral'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_oral'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['expressao_oral'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
        		<tr>
        			<td>Relacionamento com colegas</td>
        			<td class="value">{{ $recomendante['relacionamento'] == 'Excelente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['relacionamento'] == 'Bom' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['relacionamento'] == 'Regular' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['relacionamento'] == 'Insuficiente' ? 'X' : '' }}</td>
                    <td class="value">{{ $recomendante['relacionamento'] == 'Não Sabe' ? 'X' : '' }}</td>
        		</tr>
	       </tbody>
        </table>


    	<hr size="0">
    	<div>
    		<label>Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:</label>
    		<label class="motivacao"> {{ $recomendante['antecedentes_academicos'] }} </label>
    	</div>

    	<hr size="0">
    	<div>
    		<label>Opinião sobre seu possível aproveitamento, se aceito no Programa:</label>
    		<label class="motivacao"> {{ $recomendante['possivel_aproveitamento'] }} </label>
    	</div>

    	<hr size="0">
    	<div>
    		<label>Outras informaçõoes relevantes:</label>
    		<label class="motivacao"> {{ $recomendante['informacoes_relevantes'] }} </label>
    	</div>

    	<hr size="0">
    	<div>
    		<label>Entre os estudantes que já conheceu, você diria que o candidato está entre os:</label>
    		<div>
    			<label>Como aluno, em aulas: </label> {{ $recomendante['como_aluno'] }}
    		</div>
    		<div>
    			<label>Como orientando: </label> {{ $recomendante['como_orientando'] }}
    		</div>
    	</div>

    	<hr size="0">
    	<div>
    		<label>Dados do Recomendante</label>
    		<div>
    			<label>Nome: </label> {{ $recomendante['nome'] }}
    		</div>
    		<div>
    			<label>Instituição: </label> {{ $recomendante['instituicao_recomendante'] }}
    		</div>
    		<div>
    			<label>Grau acadêmico mais alto obtido: </label> {{ $recomendante['titulacao_recomendante'] }}
    		</div>
    		<div>
    			<label>Área: </label> {{ $recomendante['area_recomendante'] }}
    		</div>
    		<div>
    			<label>Ano de obtenção deste grau: </label> {{ $recomendante['ano_titulacao'] }}
    		</div>
    		<div>
    			<label>Instituição de obtenção deste grau:  </label> {{ $recomendante['inst_obtencao_titulo'] }}
    		</div>
    		<div>
    			<label>Endereço institucional do recomendante: </label> {{ $recomendante['endereco_recomendante'] }}
    		</div>
    	</div>
    	


    @endforeach
    
    

</body>

</html>