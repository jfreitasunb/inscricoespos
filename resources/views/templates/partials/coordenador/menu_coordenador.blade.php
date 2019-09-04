<div class="row">
    <div class="col-sm-3 col-md-2">
        <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseUm"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Configurar Edital</a>
                        </h4>
                    </div>
                    <div id="collapseUm" class="panel-collapse collapse {{ $keep_open_accordion_configurar_edital }}">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('configura.inscricao') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-wrench fa-fw"></span><a href="{{ route('configura.inscricao') }}">Configurar Inscrição</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('configura.periodo.confirmacao') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-wrench fa-fw"></span><a href="{{ route('configura.periodo.confirmacao') }}">Configurar Período Confirmação</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('configura.periodo.matricula') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-wrench fa-fw"></span><a href="{{ route('configura.periodo.matricula') }}">Configurar Envio de Documentos</a>
                                    </td>
                                </tr>
                            </table>
                        </div> 
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseDois"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Dados da Pós-Graduação</a>
                        </h4>
                    </div>
                    <div id="collapseDois" class="panel-collapse collapse {{ $keep_open_accordion_dados_pos }}">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('dados.coordenador.pos') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-cog fa-fw"></span><a href="{{ route('dados.coordenador.pos') }}">Dados do coordenador da Pós</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('cadastra.area.pos') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-wrench fa-fw"></span><a href="{{ route('cadastra.area.pos') }}">Cadastrar nova área Pós</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('editar.area.pos') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-wrench fa-fw"></span><a href="{{ route('editar.area.pos') }}">Editar áreas Pós</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('editar.formacao') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-wrench fa-fw"></span><a href="{{ route('editar.formacao') }}">Editar Formação</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTres"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Acompanhar Inscrições</a>
                        </h4>
                    </div>
                    <div id="collapseTres" class="panel-collapse collapse {{ $keep_open_accordion_acompanhar_inscricoes }}">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('lista.recomendacoes') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-list fa-fw"></span><a href="{{ route('lista.recomendacoes') }}">Lista as indicações por candidato</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('gera.ficha.individual') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-file fa-fw"></span><a href="{{ route('gera.ficha.individual') }}">Ver fichas individuais</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('auxilia.selecao') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-duplicate fa-fw"></span><a href="{{ route('auxilia.selecao') }}">Desclassificar Candidatos</a>
                                    </td>
                                </tr>
                            </table>
                        </div> 
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseQuatro"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Gerar Relatórios de Inscritos</a>
                        </h4>
                    </div>
                    <div id="collapseQuatro" class="panel-collapse collapse {{ $keep_open_accordion_relatorios }}">
                        <div class="panel-body">
                            <table class="table">
                                
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('relatorio.atual') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-duplicate fa-fw"></span><a href="{{ route('relatorio.atual') }}">Edital Vigente</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('relatorio.anteriores') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-backward fa-fw"></span><a href="{{ route('relatorio.anteriores') }}">Edital Anterior</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('link.acesso') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-file fa-fw"></span><a href="{{ route('link.acesso') }}">Link de Acesso</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseCinco"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Processo de Seleção</a>
                        </h4>
                    </div>
                    <div id="collapseCinco" class="panel-collapse collapse {{ $keep_open_accordion_processo_selecao }}">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('homologa.inscricoes') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-list fa-fw"></span><a href="{{ route('homologa.inscricoes') }}">Homologa Inscrições</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('seleciona.candidatos') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-list fa-fw"></span><a href="{{ route('seleciona.candidatos') }}">Candidatos Selecionados</a>
                                    </td>
                                </tr>
                            </table>
                        </div> 
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeis"><span class="glyphicon glyphicon-file fa-fw">
                            </span>Acompanha Selecionados</a>
                        </h4>
                    </div>
                    <div id="collapseSeis" class="panel-collapse collapse {{ $keep_open_accordion_acomponha_selecionados }}">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('status.selecionados') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-list fa-fw"></span><a href="{{ route('status.selecionados') }}">Status das Confirmações</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class= "{{ Route::currentRouteNamed('coordenador.documentos.matricula') ? 'active_link' : '' }}">
                                        <span class="glyphicon glyphicon-list fa-fw"></span><a href="{{ route('coordenador.documentos.matricula') }}">Documentos para Matrícula</a>
                                    </td>
                                </tr>
                            </table>
                        </div> 
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span class="glyphicon glyphicon-stats fa-fw"></span><a href="{{ route('ver.charts') }}">Estatísticas</a>
                        </h4>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span class="glyphicon glyphicon-log-out fa-fw"></span><a href="{{ route('auth.logout') }}">Sair</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-10">
            <div class="menuadmin well">
                @yield('dados_coordenador_pos')
                @yield('edita_area_pos')
                @yield('admin_impersonate')
                @yield('cadastra_area_pos')
                @yield('edita_formacao')
                @yield('configura_inscricao')
                @yield('configurar_periodo_confirmacao')
                @yield('configurar_periodo_envio_documentos_matricula')
                @yield('homologa_inscricoes')
                @yield('seleciona_candidatos')
                @yield('status_selecionados')
                @yield('tabela_indicacoes')
                @yield('relatorio_pos_edital_vigente')
                @yield('relatorio_pos_editais_anteriores')
                @yield('link_acesso')
                @yield('ficha_individual')
                @yield('graficos')
                @yield('auxilia_selecao')
                @yield('documentos_matricula_coordenador')
            </div>
        </div>
    </div>