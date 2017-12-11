<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <style>
            #logo {
                max-width:77px;
            }
            h3 {text-align:center;}
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

        <h3>
            <i>
                Carta de Recomendação enviada ao MAT/UnB para o(a) candidato(a) ao Programa de {{ $dados_para_carta_enviada['programa_pretendido'] }}: {{ $dados_para_carta_enviada['nome_candidato'] }}
            </i>
        </h3>

        <p>
            <label>Conhece o candidato há quanto tempo? </label> {{ $carta_enviada['tempo_conhece_candidato'] }}
        </p>

        <p>
            <label>Conhece o candidato sob as seguintes circunstâncias: </label> {{ $carta_enviada['circunstancia_1'] }} {{ $carta_enviada['circunstancia_2'] }} {{ $carta_enviada['circunstancia_3'] }} {{ $carta_enviada['circunstancia_4'] }}
        </p>

        <p>
            <label>Conhece o candidato sob outras circunstâncias: </label> {{ $carta_enviada['circunstancia_outra'] }}
        </p>
        
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
                    <td class="valor_celula">{{ $carta_enviada['desempenho_academico'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['desempenho_academico'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['desempenho_academico'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['desempenho_academico'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['desempenho_academico'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Capacidade de aprender novos conceitos</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_aprender'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_aprender'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_aprender'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_aprender'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_aprender'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Capacidade de trabalhar sozinho</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_trabalhar'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_trabalhar'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_trabalhar'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_trabalhar'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['capacidade_trabalhar'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Criatividade</td>
                    <td class="valor_celula">{{ $carta_enviada['criatividade'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['criatividade'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['criatividade'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['criatividade'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['criatividade'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Curiosidade</td>
                    <td class="valor_celula">{{ $carta_enviada['curiosidade'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['curiosidade'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['curiosidade'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['curiosidade'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['curiosidade'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Esforço, persistência</td>
                    <td class="valor_celula">{{ $carta_enviada['esforco'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['esforco'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['esforco'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['esforco'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['esforco'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Expressão escrita</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_escrita'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_escrita'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_escrita'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_escrita'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_escrita'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Expressão oral</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_oral'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_oral'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_oral'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_oral'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['expressao_oral'] == '5' ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Relacionamento com colegas</td>
                    <td class="valor_celula">{{ $carta_enviada['relacionamento'] == '1' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['relacionamento'] == '2' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['relacionamento'] == '3' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['relacionamento'] == '4' ? 'X' : '' }}</td>
                    <td class="valor_celula">{{ $carta_enviada['relacionamento'] == '5' ? 'X' : '' }}</td>
                </tr>
            </tbody>
        </table>


        <hr size="0">
        <p class="motivacao">
            <label>Opinião sobre os antecedentes acadêmicos, profissionais e/ou técnicos do candidato:</label>
            {{ $carta_enviada['antecedentes_academicos'] }}
        </p>

        <hr size="0">
        <p class="motivacao">
            <label>Opinião sobre seu possível aproveitamento, se aceito no Programa:</label>
            {{ $carta_enviada['possivel_aproveitamento'] }}
        </p>

        <hr size="0">
        <p class="motivacao">
            <label>Outras informaçõoes relevantes:</label>
            {{ $carta_enviada['informacoes_relevantes'] }}
        </p>

        <hr size="0">
        <div>
            <label>Entre os estudantes que já conheceu, você diria que o candidato está entre os:</label>
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
                        <td>Como aluno, em aulas</td>
                        <td class="valor_celula">{{ $carta_enviada['como_aluno'] == '1' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_aluno'] == '2' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_aluno'] == '3' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_aluno'] == '4' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_aluno'] == '5' ? 'X' : '' }}</td>
                    </tr>
                    <tr>
                        <td>Como orientado</td>
                        <td class="valor_celula">{{ $carta_enviada['como_orientando'] == '1' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_orientando'] == '2' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_orientando'] == '3' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_orientando'] == '4' ? 'X' : '' }}</td>
                        <td class="valor_celula">{{ $carta_enviada['como_orientando'] == '5' ? 'X' : '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr size="0">
        <div>
            <label>Dados do Recomendante</label>
            <div>
                <label>Nome: </label> {{ $carta_enviada['nome'] }}
            </div>
            <div>
                <label>Instituição: </label> {{ $carta_enviada['instituicao_recomendante'] }}
            </div>
            <div>
                <label>Grau acadêmico mais alto obtido: </label> {{ $carta_enviada['titulacao_recomendante'] }}
            </div>
            <div>
                <label>Área: </label> {{ $carta_enviada['area_recomendante'] }}
            </div>
            <div>
                <label>Ano de obtenção deste grau: </label> {{ $carta_enviada['ano_titulacao'] }}
            </div>
            <div>
                <label>Instituição de obtenção deste grau:  </label> {{ $carta_enviada['inst_obtencao_titulo'] }}
            </div>
            <div>
                <label>Endereço institucional do recomendante: </label> {{ $carta_enviada['endereco_recomendante'] }}
            </div>
        </div>
    </body>
</html>