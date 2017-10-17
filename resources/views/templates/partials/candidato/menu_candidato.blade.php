<div class="row">
  <nav class="navbar navbar-default col-md-8 col-md-offset-2" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bar1">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bar1">
      <ul class="nav navbar-nav">
        <li class="{{ Route::currentRouteNamed('dados.pessoais') ? 'active' : '' }}"><a href="{{ route('dados.pessoais') }}">{{trans('tela_dados_pessoais.tela_dados_pessoais')}}</a></li>
        <li class="{{ Route::currentRouteNamed('dados.academicos') ? 'active' : '' }}"><a href="{{ route('dados.academicos') }}">{{ trans('tela_dados_academicos.tela_dados_academicos') }}</a></li>
        <li class="{{ Route::currentRouteNamed('dados.escolhas') ? 'active' : '' }}"><a href="{{ route('dados.escolhas') }}">{{ trans('tela_escolha_candidato.tela_escolhas') }}</a></li>
        <li class="{{ Route::currentRouteNamed('finalizar.inscricao') ? 'active' : '' }}"><a href="{{ route('finalizar.inscricao') }}">{{ trans('tela_finalizar_inscricao.tela_finaliza') }}</a></li>
        <li class="{{ Route::currentRouteNamed('auth.logout') ? 'active' : '' }}"><a href="{{ route('auth.logout') }}">Sair</a></li>
      </ul>
    </div>
  </nav>
</div>