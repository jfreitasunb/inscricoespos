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
                padding: 5px;
            }

            table.customTable thead {
                background-color: #F8F8F8;
            }
        </style>
    </head>

    <body>
        <script type="text/php">
            if (isset($pdf)) {
                $font = $fontMetrics->getFont("Arial", "bold");
                $pdf->page_text(35, 750, "MAT/UnB", $font, 7, array(0, 0, 0) );
                $pdf->page_text(540, 750, "Página {PAGE_NUM}/{PAGE_COUNT}", $font, 7, array(0, 0, 0));
            }
        </script>

        <h2>Homologação das inscrições para o Programa de Pós-graduação em Matemática - {{ $dados_homologacao['numero_semestre'] }}º/{{ $dados_homologacao['ano_inicio'] }}</h2>
        <div>
            <p>O Departamento de Matemática torna pública a homologação das inscrições para {{ $dados_homologacao['texto_cursos_pos'] }} em Matemática, com início no {{ $dados_homologacao['texto_semestre'] }} período letivo de {{ $dados_homologacao['ano_inicio'] }}, conforme item 7.1 do edital nº {{ $dados_homologacao['edital'] }}. </p>
        </div>

        <div><br></div>

        <div>
            @foreach ($homologacoes as $key => $candidato)
            
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
            @endforeach
        </div>
        <div><br></div>
        <div>
            <p align="right">Brasília, {{ $dados_homologacao['dia'] }} de {{ $dados_homologacao['nome_mes'] }} de {{ $dados_homologacao['ano_homologacao'] }}</p>
        </div>
        <div><br></div>
        <div>
            <p align="center">{{ $dados_homologacao['nome_coordenador'] }}</p>
            <p align="center">{{ $dados_homologacao['tratamento'] }} de Pós-Graduação MAT/UnB</p>
        </div>
    </body>
</html>