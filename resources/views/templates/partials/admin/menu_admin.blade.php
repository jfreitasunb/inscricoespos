<div class="row">
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
        <li class="{{ Route::currentRouteNamed('ativa.conta') ? 'active' : '' }}"><a href="{{ route('ativa.conta') }}">Ativar Conta</a></li>
        <li class="{{ Route::currentRouteNamed('pesquisar.papel') ? 'active' : '' }}"><a href="{{ route('pesquisar.papel') }}">Atribuir Papel</a></li>
        <li class="{{ Route::currentRouteNamed('criar.coordenador') ? 'active' : '' }}"><a href="{{ route('criar.coordenador') }}">Cria Coordenador</a></li>
        <li class="{{ Route::currentRouteNamed('cadastra.disciplina') ? 'active' : '' }}"><a href="{{ route('cadastra.disciplina') }}">Cadastrar Disciplina</a></li>
        <li class="{{ Route::currentRouteNamed('configura.monitoria') ? 'active' : '' }}"><a href="{{ route('configura.monitoria') }}">Configurar Inscrição</a></li>
        <li class="{{ Route::currentRouteNamed('relatorio.monitoria') ? 'active' : '' }}"><a href="{{ route('relatorio.monitoria') }}">Relatórios</a></li>
        <li class="{{ Route::currentRouteNamed('auth.logout') ? 'active' : '' }}""><a href="{{ route('auth.logout') }}">Sair</a></li>
      </ul>
    </div>
  </nav>
</div>