<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <style>
            h2 {text-align:center;}
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

        <h2>Ficha de Inscrição - {{ $dados_candidato_para_relatorio['programa_pretendido'] }}</h2>
        
        <div class="form-control">
            <b>Nome: </b> <em>{{ $dados_candidato_para_relatorio['nome'] }}</em>
        </div>
        
        <div class="form-control">
            <b>E-mail: </b> <em>{{ $dados_candidato_para_relatorio['email'] }}</em>
        </div>
        
        <div class="form-control">
            <b>Data de nascimento: </b> <em>{{ $dados_candidato_para_relatorio['data_nascimento'] }}</em>

        </div>
        
        <div class="form-control">
            <b>Idade: </b> <em>{{ $dados_candidato_para_relatorio['idade'].' anos' }}</em>
        </div>
        
        <hr>
        
        <h3>Endereço Pessoal</h3>
        
        <div class="form-control">
            <b>Endereço: </b> <em>{{ $dados_candidato_para_relatorio['endereco'] }}</em>
        </div>

        <div class="form-control">
            <b>Celular: </b> <em>{{ $dados_candidato_para_relatorio['celular'] }}</em>
        </div>
        
        <div class="form-control">
            <b>País: </b> <em>{{ $dados_candidato_para_relatorio['nome_pais'] }}</em>
        </div>

        <div class="form-control">
            <b> Estado: </b> <em>{{ $dados_candidato_para_relatorio['nome_estado'] }}</em>
        </div>

        <div class="form-control">
            <b>Cidade: </b> <em>{{ $dados_candidato_para_relatorio['nome_cidade'] }}</em>
        </div>

        <hr>

        <h3>Dados Acadêmicos</h3>
        
        <div class="form-control">
            <b>Graduação: </b> <em>{{ $dados_candidato_para_relatorio['curso_graduacao'] }}</em>
        </div>

        <div class="form-control">
            <b>Tipo: </b> <em>{{ $dados_candidato_para_relatorio['tipo_curso_graduacao'] }}</em>
        </div>

        <div class="form-control">
            <b>Instituição: </b> <em>{{ $dados_candidato_para_relatorio['instituicao_graduacao'] }}</em>
        </div>

        <div class="form-control">
            <b>Ano de Conclusão (ou previsão): </b> <em>{{ $dados_candidato_para_relatorio['ano_conclusao_graduacao'] }}</em>
        </div>

        @if ($dados_candidato_para_relatorio['curso_pos'])
            <hr size="0">
            
            <div class="form-control">
                <b>Pós-Graduação: </b> <em>{{ $dados_candidato_para_relatorio['curso_pos'] }}</em>
            </div>
            
            <div class="form-control">
                <b>Tipo: </b> <em>{{ $dados_candidato_para_relatorio['tipo_curso_pos'] }}</em>
            </div>

            <div class="form-control">
                <b>Instituição: </b> <em>{{ $dados_candidato_para_relatorio['instituicao_pos'] }}</em>
            </div>

            <div class="form-control">
                <b>Ano de Conclusão (ou previsão): </b> <em>{{ $dados_candidato_para_relatorio['ano_conclusao_pos'] }}</em>
            </div>
        @endif

<hr>
        <h3>Programa pretendido</h3>

        <div class="form-control">
            <b>Programa pretendido: </b><em>{{ $dados_candidato_para_relatorio['programa_pretendido'] }}</em> {!! array_key_exists('area_pos_principal',$dados_candidato_para_relatorio) ? '<b> Área Principal: </b><em>'.$dados_candidato_para_relatorio['area_pos_principal']: '' !!} {!! array_key_exists('area_pos_secundaria',$dados_candidato_para_relatorio) ? '</em><b> Área Secundária: </b><em>'.$dados_candidato_para_relatorio['area_pos_secundaria']: '' .'</em>'!!}
        </div>

        <div class="form-control">
            <b>Início no programa: </b><em>{{ $dados_candidato_para_relatorio['semestre_inicio'] }}</em>
        </div>

        <div class="form-control">
            <b>Interesse em bolsa: </b><em>{{ $dados_candidato_para_relatorio['interesse_bolsa'] ? 'Sim' : 'Não' }}</em>
        </div>

        <div class="form-control">
            <b>Possui vínculo empregatício: </b><em>{{ $dados_candidato_para_relatorio['vinculo_empregaticio'] ? 'Sim' : 'Não' }}</em>
	   </div>

        @if (isset($dados_candidato_para_relatorio['tipo_cotista']))
            <hr>

            <h3>{{ trans('tela_escolha_candidato.cotista') }}</h3>
            
            <div class="form-control">
                @foreach (explode("_", $dados_candidato_para_relatorio['tipo_cotista']) as $tipo)
                    <ul>
                        <li><em>{{ $tipo }}</em></li>
                    </ul>
                @endforeach
            </div>
        @endif

        @if ($necessita_recomendante)
            <hr>

            <h3>Dados dos Recomendantes</h3>
            
            @foreach ($recomendantes_candidato as $recomendante)
                <div class="form-control">
                    <b> Nome: </b> <em>{{ $recomendante['nome'] }}</em> <b>Email: </b> <em>{{ $recomendante['email'] }}</em>
                </div>
            @endforeach

            <hr>

            <h4>Motivação e expectativa do candidato em relação ao programa pretendido</h4>
            
            <p class="motivacao">
                {!! $dados_candidato_para_relatorio['motivacao'] !!}
            </p>

            @foreach ($recomendantes_candidato as $recomendante)
                <div class="page_break"></div>
                
                <h3>Carta de Recomendação - {{ $recomendante['nome'] }}</h3>
                
                <div class="form-control">
                    <b>Conhece o candidato há quanto tempo? </b> <em>{{ $recomendante['tempo_conhece_candidato'] }}</em>
                </div>

                <div class="form-control">
                    <b>Conhece o candidato sob as seguintes circunstâncias:</b>
                </div>

                <div class="form-control">
                    <p class="motivacao"><em>{{ $recomendante['circunstancia_1'] }} {{ $recomendante['circunstancia_2'] }} {{ $recomendante['circunstancia_3'] }} {{ $recomendante['circunstancia_4'] }}</em></p>
                </div>

                <div class="form-control">
                    <b>Conhece o candidato sob outras circunstâncias:</b>
                </div>

                <p class="motivacao">{!! $recomendante['circunstancia_outra'] !!}</p>
                
                <hr size="0">
                
                <b>Avaliações</b>

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
                            <td class="valor_celula">{{ $recomendante['desempenho_academico'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['desempenho_academico'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['desempenho_academico'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['desempenho_academico'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['desempenho_academico'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Capacidade de aprender novos conceitos</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_aprender'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_aprender'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_aprender'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_aprender'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_aprender'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Capacidade de trabalhar sozinho</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_trabalhar'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_trabalhar'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_trabalhar'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_trabalhar'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['capacidade_trabalhar'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Criatividade</td>
                            <td class="valor_celula">{{ $recomendante['criatividade'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['criatividade'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['criatividade'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['criatividade'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['criatividade'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Curiosidade</td>
                            <td class="valor_celula">{{ $recomendante['curiosidade'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['curiosidade'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['curiosidade'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['curiosidade'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['curiosidade'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Esforço, persistência</td>
                            <td class="valor_celula">{{ $recomendante['esforco'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['esforco'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['esforco'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['esforco'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['esforco'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Expressão escrita</td>
                            <td class="valor_celula">{{ $recomendante['expressao_escrita'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_escrita'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_escrita'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_escrita'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_escrita'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Expressão oral</td>
                            <td class="valor_celula">{{ $recomendante['expressao_oral'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_oral'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_oral'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_oral'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['expressao_oral'] == '5' ? 'X' : '' }}</td>
                        </tr>
                        <tr>
                            <td>Relacionamento com colegas</td>
                            <td class="valor_celula">{{ $recomendante['relacionamento'] == '1' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['relacionamento'] == '2' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['relacionamento'] == '3' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['relacionamento'] == '4' ? 'X' : '' }}</td>
                            <td class="valor_celula">{{ $recomendante['relacionamento'] == '5' ? 'X' : '' }}</td>
                        </tr>
                    </tbody>
                </table>

                <hr size="0">

                <div class="form-control">
                    <b>Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:</b>
                </div>

                <div class="form-control">
                    <p class="motivacao"><em>{!! $recomendante['antecedentes_academicos'] !!}</em></p>
                </div>

                <div class="form-control">
                    <b>Opinião sobre seu possível aproveitamento, se aceito no  Programa:</b>
                </div>

                <div class="form-control">
                    <p class="motivacao"><em>{!! $recomendante['possivel_aproveitamento'] !!}</em></p>
                </div>

                <hr size="0">

                <div class="form-control">
                    <label>Outras informaçõoes relevantes:</label>
                </div>

                <div class="form-control">
                    <p class="motivacao"><em>{!! $recomendante['informacoes_relevantes'] !!}</em></p>
                </div>

                <hr size="0">

                <div class="form-control">
                    <label>Entre os estudantes que já conheceu, você diria que o candidato</label>
                </div>

                <div class="form-control">
                    <label>está entre os:</label>
                </div>

                <div class="form-control">
                    <table class="tftable" border="1">
                        <tbody>
                            <tr>
                                <td> </td>
                                <td class="cabecalho">5% melhores</td>
                                <td class="cabecalho">10% melhores</td>
                                <td class="cabecalho">25% melhores</td>
                                <td class="cabecalho">50% melhores</td>
                                <td class="cabecalho">Não Sabe</td>
                            </tr>
                            <tr>
                                <td>Como aluno, em aulas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td class="valor_celula">{{ $recomendante['como_aluno'] == '1' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_aluno'] == '2' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_aluno'] == '3' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_aluno'] == '4' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_aluno'] == '5' ? 'X' : '' }}</td>
                            </tr>
                            <tr>
                                <td>Como orientado</td>
                                <td class="valor_celula">{{ $recomendante['como_orientando'] == '1' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_orientando'] == '2' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_orientando'] == '3' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_orientando'] == '4' ? 'X' : '' }}</td>
                                <td class="valor_celula">{{ $recomendante['como_orientando'] == '5' ? 'X' : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr size="0">

                <div class="form-control">
                    <label>Dados do Recomendante</label>

                    <div class="form-control">
                        <b>Nome: </b> <em>{{ $recomendante['nome'] }}</em>
                    </div>

                    <div class="form-control">
                        <b>Instituição: </b> <em>{{ $recomendante['instituicao_recomendante'] }}</em>
                    </div>

                    <div class="form-control">
                        <b>Grau acadêmico mais alto obtido: </b> <em>{{ $recomendante['titulacao_recomendante'] }}</em>
                    </div>

                    <div class="form-control">
                        <b>Área: </b> <em>{{ $recomendante['area_recomendante'] }}</em>
                    </div>

                    <div class="form-control">
                        <b>Ano de obtenção deste grau: </b> <em>{{ $recomendante['ano_titulacao'] }}</em>
                    </div>

                    <div class="form-control">
                        <b>Instituição de obtenção deste grau: </b> <em>{{ $recomendante['inst_obtencao_titulo'] }}</em>
                    </div>

                    <div class="form-control">
                        <label>Endereço institucional do recomendante: </label> <em>{!! $recomendante['endereco_recomendante'] !!}</em>
                    </div>
                </div>
            @endforeach
        @endif
        
    </body>
</html>
