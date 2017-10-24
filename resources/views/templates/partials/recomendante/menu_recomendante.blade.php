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
        <li class="{{ Route::currentRouteNamed('dados.pessoais') ? 'active' : '' }}"><a href="{{ route('dados.pessoais') }}">{{trans('tela_recomendante_dados_pessoais.tela_dados_pessoais')}}</a></li>
        @liberacarta(Auth()->user())
        <li class="{{ Route::currentRouteNamed('cartas.pendentes') ? 'active' : '' }}"><a href="{{ route('cartas.pendentes') }}">{{ trans('tela_escolha_candidato.tela_escolhas') }}</a></li>
        <li class="{{ Route::currentRouteNamed('motivacao.documentos') ? 'active' : '' }}"><a href="{{ route('motivacao.documentos') }}">{{ trans('tela_motivacao_documentos.tela_motivacao_documentos') }}</a></li>
        @endliberacarta
        @statuscarta
          <li class="{{ Route::currentRouteNamed('status.cartas') ? 'active' : '' }}"><a href="{{ route('status.cartas') }}">{{ trans('tela_status_cartas.status_cartas') }}</a></li>
        @endstatuscarta
        <li class="{{ Route::currentRouteNamed('auth.logout') ? 'active' : '' }}"><a href="{{ route('auth.logout') }}">Sair</a></li>
      </ul>
    </div>
  </nav>
</div>