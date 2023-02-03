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
            <img src="{!! public_path("/imagens/logo/logo_unb_para_relatorios.png") !!}" id="logo" style="float: left;" />
            <h4>
                Departamento de Matemática<br>
                Programa de Pós-Graduação do MAT/UnB
            </h4>
        </p>
       
        <h2>
            {{ trans('tela_finalizar_inscricao.ficha_inscricao') }} - {{ $dados_candidato_para_relatorio['programa_pretendido'] }}</h2>

        <div>
            <label>{{ trans('tela_dados_pessoais.nome') }}: &nbsp;</label> {{ $dados_candidato_para_relatorio['nome'] }}
        </div>
        <div>
            <label>{{ trans('tela_dados_pessoais.data_nascimento') }}: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['data_nascimento'] }}
        </div>
        <hr>
        <h3>{{ trans('tela_dados_pessoais.endereco_pessoal') }}</h3>
        <div>
            <label>{{ trans('tela_dados_pessoais.endereco') }}: &nbsp;&nbsp;&nbsp; </label> {{ $dados_candidato_para_relatorio['endereco'] }}
        </div>
        <div>
            <label>{{ trans('tela_dados_pessoais.celular') }}: &nbsp;&nbsp;&nbsp;&nbsp; </label> {{ $dados_candidato_para_relatorio['celular'] }}
        </div>
        <div>
            <label>{{ trans('tela_dados_pessoais.pais') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['nome_pais'] }}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label> {{ trans('tela_dados_pessoais.estado') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['nome_estado'] }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label> {{ trans('tela_dados_pessoais.cidade') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['nome_cidade'] }}
        </div>

        <hr>
        <h3>{{ trans('tela_dados_academicos.tela_dados_academicos') }}</h3>
        <div>
            <label>{{ trans('tela_dados_academicos.curso_graduacao') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['curso_graduacao'] }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>{{ trans('tela_dados_academicos.tipo_curso') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['tipo_curso_graduacao'] }}

        </div>
        <div>
            <label>{{ trans('tela_dados_academicos.instituicao') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['instituicao_graduacao'] }}
        </div>
        <div>
            <label>{{ trans('tela_dados_academicos.ano_conclusao') }}: &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['ano_conclusao_graduacao'] }}
        </div>
        @if ($dados_candidato_para_relatorio['curso_pos'])
        <hr size="0">
        <div>
            <label>{{ trans('tela_dados_academicos.curso_pos') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['curso_pos'] }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label>{{ trans('tela_dados_academicos.tipo_curso') }}: &nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['tipo_curso_pos'] }}
        </div>
        <div>
            <label>{{ trans('tela_dados_academicos.instituicao') }}: &nbsp;&nbsp;&nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['instituicao_pos'] }}
        </div>
        <div>
            <label>{{ trans('tela_dados_academicos.ano_conclusao') }}: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['ano_conclusao_pos'] }}
        </div>
        @endif

        <hr>
        <h3>{{ trans('tela_escolha_candidato.tela_escolhas') }}</h3>
        <div>
            <label>{{ trans('tela_escolha_candidato.programa_disponivel') }}: &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</label>{{ $dados_candidato_para_relatorio['programa_pretendido'] }}<br/><label>Semestre para início: &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</label>{{ $dados_candidato_para_relatorio['semestre_inicio'] }} {!! array_key_exists('area_pos_principal',$dados_candidato_para_relatorio) ? '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<label> Área Principal: </label>'.$dados_candidato_para_relatorio['area_pos_principal']: '' !!} {!! array_key_exists('area_pos_secundaria',$dados_candidato_para_relatorio) ? '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<label> Área Secundária: </label>'.$dados_candidato_para_relatorio['area_pos_secundaria']: '' !!}
        </div>
        <div>
            <label>{{ trans('tela_escolha_candidato.interesse_bolsa') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['interesse_bolsa'] ?  trans('tela_escolha_candidato.sim')  :  trans('tela_escolha_candidato.nao') }}
        </div>
        <div>
            <label>{{ trans('tela_escolha_candidato.vinculo_empregaticio') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> {{ $dados_candidato_para_relatorio['vinculo_empregaticio'] ? trans('tela_escolha_candidato.sim')  :  trans('tela_escolha_candidato.nao') }}
        </div>

        @if (isset($dados_candidato_para_relatorio['tipo_cotista']))
            <hr>
            <h3>{{ trans('tela_escolha_candidato.cotista') }}</h3>
            <div>
            @foreach (explode("_", $dados_candidato_para_relatorio['tipo_cotista']) as $tipo)
                <ul>
                    <li>{{ $tipo }}</li>
                </ul>
            @endforeach
            </div>
        @endif

        @if ($necessita_recomendante)
            <hr>
            <h3>{{ trans('tela_escolha_candidato.recomendante') }}</h3>
            @foreach ($recomendantes_candidato as $recomendante)
            <div>
                <label> {{ trans('tela_escolha_candidato.nome') }} &nbsp;&nbsp;&nbsp;&nbsp;</label> {{ $recomendante['nome'] }}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; <label>Email: &nbsp;&nbsp;&nbsp;&nbsp;</label>{{ $recomendante['email'] }}
            </div>
            @endforeach
        @endif
        
        <hr>
        <h3>{{ trans('tela_motivacao_documentos.tela_motivacao_documentos') }}</h3>
        <p class="motivacao">
            {!! $dados_candidato_para_relatorio['motivacao'] !!}
        </p>
    </body>
</html>
