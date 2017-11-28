{{-- <div class="row">
  <nav class="navbar navbar-default-admin col-md-7 col-md-offset-3" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bar1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bar1">
      <ul class="nav navbar-nav">
        <li class="{{ Route::currentRouteNamed('lista.usuarios') ? 'active' : '' }}"><a href="{{ route('lista.usuarios') }}">Usuários</a></li>
        <li class="{{ Route::currentRouteNamed('ativa.conta') ? 'active' : '' }}"><a href="{{ route('ativa.conta') }}">Ativar Conta</a></li>
        <li class="{{ Route::currentRouteNamed('pesquisar.papel') ? 'active' : '' }}"><a href="{{ route('pesquisar.papel') }}">Atribuir Papel</a></li>
        <li class="{{ Route::currentRouteNamed('criar.coordenador') ? 'active' : '' }}"><a href="{{ route('criar.coordenador') }}">Cria Coordenador</a></li>
        <li class="{{ Route::currentRouteNamed('cadastra.disciplina') ? 'active' : '' }}"><a href="{{ route('cadastra.disciplina') }}">Cadastrar Disciplina</a></li>
        <li class="{{ Route::currentRouteNamed('configura.inscricao') ? 'active' : '' }}"><a href="{{ route('configura.inscricao') }}">Configurar Inscrição</a></li>
        <li class="{{ Route::currentRouteNamed('relatorio.atual') ? 'active' : '' }}"><a href="{{ route('relatorio.atual') }}">Relatórios</a></li>
        <li class="{{ Route::currentRouteNamed('relatorio.anteriores') ? 'active' : '' }}"><a href="{{ route('relatorio.anteriores') }}">Relatórios Editais Anteriores</a></li>
        <li class="{{ Route::currentRouteNamed('auth.logout') ? 'active' : '' }}"><a href="{{ route('auth.logout') }}">Sair</a></li>
      </ul>
    </div>
  </nav>
</div> --}}

<div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
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
                                        <a href="{{ route('ativa.conta') }}">Ativar conta</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('pesquisar.papel') }}">Atribuir Papel</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        </span><a href="{{ route('criar.coordenador') }}" class="text-danger">
                                            Cria Coordenador</a>
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
                                        <span class="glyphicon glyphicon-user"></span><a href="http://www.jquery2dotnet.com">Editar Inscrição</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="http://www.jquery2dotnet.com">Reativar Inscrição Candidato</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="http://www.jquery2dotnet.com">Reativar Carta</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="http://www.jquery2dotnet.com">Mudar Recomendante</a>
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
         <div class="col-sm-9 col-md-9">
            <div class="well">
                <h1>
                    Accordion Menu With Icon</h1>
                Admin Dashboard Accordion Menu
            </div>
        </div>
    </div>