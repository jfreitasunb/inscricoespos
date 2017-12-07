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
        <li class="{{ Route::currentRouteNamed('dados.recomendante') ? 'active' : '' }}"><a href="{{ route('dados.recomendante') }}">{{trans('tela_recomendante_dados_pessoais.tela_dados_pessoais')}}</a></li>
        @liberacarta(Auth()->user())
          <li class="{{ Route::currentRouteNamed('cartas.pendentes') ? 'active' : '' }}"><a href="{{ route('cartas.pendentes') }}">{{ trans('tela_cartas_pendentes.tela_pendentes') }}</a></li>
        @endliberacarta
        <li class="{{ Route::currentRouteNamed('cartas.anteriores') ? 'active' : '' }}"><a href="{{ route('cartas.anteriores') }}">{{ trans('tela_cartas_anteriores.tela_cartas_anteriores') }}</a></li>
        <li class="{{ Route::currentRouteNamed('auth.logout') ? 'active' : '' }}"><a href="{{ route('auth.logout') }}">Sair</a></li>
        @impersonating_recomendante
          <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('impersonating').submit();">Voltar ao Admin</a>
          </li>

          {!! Form::open(array('route' => 'admin.impersonate', 'id' => 'impersonating', 'class' => 'hidden')) !!}
            {{ method_field('DELETE') }}
          {!! Form::close() !!}

        @endimpersonating_recomendante
      </ul>
    </div>
  </nav>
</div>