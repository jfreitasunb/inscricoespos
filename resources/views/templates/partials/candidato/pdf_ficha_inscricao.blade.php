<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <style>
            #logo {
                max-width:77px;
            }
            h2 {text-align:center;}
            h4 {text-align:left;}
            label {font-weight: bold;}
            label.motivacao {font-weight: normal;text-align:justify;}
            p.motivacao {font-weight: normal;text-align:justify;}
            .page_break { page-break-before: always;}
            table.tftable {font-size:12px;width:100%;border-width: 1px;border-collapse: collapse;}
    		table.tftable th {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;text-align:center;}
    		table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;}
            table.tftable td.valor_celula {text-align:center;font-weight: bold;font-size:14px;border-width: 1px;padding: 8px;border-style: solid;}
            table.tftable td.cabecalho {text-align:center;font-size:12px;border-width: 1px;padding: 8px;border-style: solid;}
            .footer {
                width: 100%;
                text-align: center;
                position: fixed;
                font-size: 8pt;
                bottom: 0px;
            }
            .pagenum:before {
                content: counter(page);
            }
            p:last-child { page-break-after: never; }
        </style>
    </head>

    <body>
        <script type="text/php">
            if (isset($pdf)) {
                $font = $fontMetrics->getFont("Arial", "bold");
                $pdf->page_text(35, 750, "{{  $dados_candidato_para_relatorio['nome'] }}", $font, 7, array(0, 0, 0) );
                $pdf->page_text(540, 750, "Página {PAGE_NUM}/{PAGE_COUNT}", $font, 7, array(0, 0, 0));
            }
        </script>

        <p style="width: 500px;">
            <img src="{!! public_path("/imagens/logo/logo_unb.png") !!}" id="logo" style="float: left;" />
            <h4>
                Departamento de Matemática<br>
                Programa de Pós-Graduação do MAT/UnB
            </h4>
        </p>
       
        <h2>
                Ficha de Inscrição - {{ $dados_candidato_para_relatorio['programa_pretendido'] }} {{ $dados_candidato_para_relatorio['area_pos'] ? ' - '.$dados_candidato_para_relatorio['area_pos']: '' }}</h2>

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
        <p class="motivacao">
            {{ $dados_candidato_para_relatorio['motivacao'] }}
        </p>
    </body>
</html>