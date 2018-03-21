<div class="row">
  <nav class="navbar navbar-default-coord col-md-8 col-md-offset-2" role="navigation">
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
        <li class="{{ Route::currentRouteNamed('configura.inscricao') ? 'active' : '' }}"><a href="{{ route('configura.inscricao') }}">Configurar Inscrição</a></li>
        <li class="{{ Route::currentRouteNamed('cadastra.area.pos') ? 'active' : '' }}"><a href="{{ route('cadastra.area.pos') }}">Cadastrar nova área Pós</a></li>
        <li class="{{ Route::currentRouteNamed('editar.area.pos') ? 'active' : '' }}"><a href="{{ route('editar.area.pos') }}">Editar áreas Pós</a></li>
        <li class="{{ Route::currentRouteNamed('editar.formacao') ? 'active' : '' }}"><a href="{{ route('editar.formacao') }}">Editar Formação</a></li>
        <li class="{{ Route::currentRouteNamed('relatorio.atual') ? 'active' : '' }}"><a href="{{ route('relatorio.atual') }}">Relatórios Edital Vigente</a></li>
        <li class="{{ Route::currentRouteNamed('gera.ficha.individual') ? 'active' : '' }}"><a href="{{ route('gera.ficha.individual') }}">Ficha Individual</a></li>
        <li class="{{ Route::currentRouteNamed('relatorio.anteriores') ? 'active' : '' }}"><a href="{{ route('relatorio.anteriores') }}">Relatórios Editais Anteriores</a></li>
        <li class="{{ Route::currentRouteNamed('auth.logout') ? 'active' : '' }}"><a href="{{ route('auth.logout') }}">Sair</a></li>
      </ul>
    </div>
  </nav>
</div>