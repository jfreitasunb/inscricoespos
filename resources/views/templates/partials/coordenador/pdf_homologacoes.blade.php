<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
            body {
                margin: 100px;
            }

            #header{
                position: fixed;
            }

            #unb{
                font-size: 10px;
            }

            #ied{
                font-size: 8px;
            }

            #fonemat{
                font-size: 8px;
                text-align: right;
                margin-top: -5px;
            }
            

            h2 {text-align:center;}
            
            label {font-weight: bold;}
            
            label.motivacao {font-weight: normal;text-align:justify;}
            
            p.motivacao {font-weight: normal;text-align:justify;}
            
            .page_break { page-break-before: always;}
            
            .pagenum:before {
                content: counter(page);
            }
            
            p:last-child { page-break-after: never; }
            
            table.customTable {
                border-collapse: collapse;
                border-width: 2px;
                border-color: #080A0F;
                border-style: solid;
                color: #000000;
            }

            table.customTable th.tg-baqh{
                width: 10%;
            }
            table.customTable th.tg-0lax{
                width: 100%;
            }

            tr:nth-child(even) {
                background-color: #B3B3B3
            }

            table.customTable td, table.customTable th {
                border-width: 2px;
                border-color: #080A0F;
                border-style: solid;
            }
        </style>
    </head>

    <body>
        <script type="text/php">
            if (isset($pdf)) {
                $w = $pdf->get_width();
                $font = $fontMetrics->getFont("Arial", "bold");
                $pdf->page_script('
                    $w = $pdf->get_width();
                    $pdf->line(35,750,$w-35,750,array(0,0,0),0.5);
                ');
                {{-- $pdf->line(35,10,$w-35,10,array(0,0,0),1.5);
                $pdf->page_text(35, 10, "UnB-Universidade de Brasília", $font, 7, array(0, 0, 0));
                $pdf->page_text(35, 20, "IE-Instituto de Ciências Exatas", $font, 7, array(0, 0, 0) );
                $pdf->page_text(35, 30, "MAT-Departamento de Matemática", $font, 7, array(0, 0, 0) );
                
                $pdf->page_text(35, 40, "Campus Universitário Darcy Ribeiro 70.910-900", $font, 7, array(0, 0, 0) );
                $pdf->page_text(440, 40, "Fone: (61) 3107-6479/6480 Fax: (61) 3107-6482", $font, 7, array(0, 0, 0) ); --}}
                $pdf->page_text(40, 750, "PPG/MAT-UnB", $font, 7, array(0, 0, 0));
                $pdf->page_text(540, 750, "Página {PAGE_NUM}/{PAGE_COUNT}", $font, 7, array(0, 0, 0));
            }
        </script>
        <div id="header">
            <hr style="height:1.5px;border:none;color:#333;background-color:#333;">
            <div id="unb">
                UnB-Universidade de Brasília
            </div>
            <div id="ied">
                <img src="{{ public_path('imagens/logo/unb_contorno.png') }}" alt="Logo" height="25px" align="right" vspace="-10px">
                IE-Instituto de Ciências Exatas<br>MAT-Departamento de Matemática
                <br>
                <hr style="height:0.75px;border:none;color:#333;background-color:#333;">
                Campus Universitário Darcy Ribeiro 70.910-900
                <br>
            </div>
                <div id="fonemat">Fone: (61) 3107-6479/6480 Fax: (61) 3107-6482</div></div>
        <div>
            <h2>Homologação das inscrições para o Programa de Pós-Graduação em Matemática - {{ $dados_homologacao['numero_semestre'] }}º/{{ $dados_homologacao['ano_inicio'] }}</h2>
            <div>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O Departamento de Matemática torna pública a homologação das inscrições para {{ $dados_homologacao['texto_cursos_pos'] }} em Matemática, com início no {{ $dados_homologacao['texto_semestre'] }} período letivo de {{ $dados_homologacao['ano_inicio'] }}, conforme item 7.1 do edital nº {{ $dados_homologacao['edital'] }}. </p>
            </div>
        </div>
        
        @foreach ($homologacoes as $key => $candidato)
            <div id="wrap_tabela">
                <h3 align="center">{{ $key }}:</h3>
                <table class="customTable" align="center">
                  <tr>
                    <th class="tg-baqh" align="center">Ordem</th>
                    <th class="tg-0lax" align="center">Nome</th>
                  </tr>
                  @foreach ($candidato as $ordem => $nome)
                    <tr>
                        <td class="tg-baqh" align="center">{{ $ordem + 1}}</td>
                        <td class="tg-0lax">{{ $nome }}</td>
                    </tr>
                  @endforeach
                </table>
            </div>
        @endforeach
        <div>
            <p align="center">Brasília, {{ $dados_homologacao['dia'] }} de {{ $dados_homologacao['nome_mes'] }} de {{ $dados_homologacao['ano_homologacao'] }}</p>
            <p align="center">{{ $dados_homologacao['nome_coordenador'] }}</p>
            <p align="center">{{ $dados_homologacao['tratamento'] }} de Pós-Graduação MAT/UnB</p>
        </div>
    </body>
</html>