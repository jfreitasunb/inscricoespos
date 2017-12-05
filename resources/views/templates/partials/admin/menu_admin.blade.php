<div class="row">
    <div class="col-sm-3 col-md-2">
        <div class="panel-group" id="accordion">
            <div class="menuadmin panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseUm"><span class="glyphicon glyphicon-user">
                        </span>Contas</a>
                    </h4>
                </div>
                <div id="collapseUm" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td>
                                    <a href="{{ route('lista.usuarios') }}">Lista usuários</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ route('pesquisa.usuario') }}">Ativar/Alterar conta</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span><a href="{{ route('criar.coordenador') }}" class="text-danger">
                                        Cria Coordenador</a></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseDois"><span class="glyphicon glyphicon-file">
                            </span>Inscrições</a>
                        </h4>
                    </div>
                    <div id="collapseDois" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-usd"></span><a href="{{ route('configura.inscricao') }}">Configurar Inscrição</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="{{ route('editar.inscricao') }}">Editar Inscrição</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="{{ route('reativar.candidato') }}">Reativar Inscrição Candidato</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="{{ route('pesquisa.carta') }}">Reativar Carta</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="{{ route('pesquisa.recomendantes') }}">Mudar Recomendante</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTres"><span class="glyphicon glyphicon-file">
                            </span>Relatórios</a>
                        </h4>
                    </div>
                    <div id="collapseTres" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-usd"></span><a href="{{ route('relatorio.atual') }}">Edital Vigente</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="{{ route('relatorio.anteriores') }}">Edital Anterior</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-tasks"></span><a href="{{ route('gera.ficha.individual') }}">Por Candidato</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span class="glyphicon glyphicon-log-out"></span><a href="{{ route('auth.logout') }}">Sair</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-10">
            <div class="menuadmin well">
                @yield('ativa_conta')
                @yield('cadastra_disciplina')
                @yield('configura_inscricao')
                @yield('editar_inscricao')
                @yield('reativar_inscricao_candidato')
                @yield('reativar_carta_enviada')
                @yield('altera_recomendantes')
                @yield('relatorio_pos_edital_vigente')
                @yield('relatorio_pos_editais_anteriores')
                @yield('datatable_users')
                @yield('ficha_individual')
            </div>
        </div>
    </div>