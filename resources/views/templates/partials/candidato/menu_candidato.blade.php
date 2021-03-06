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
        <li class="{{ Route::currentRouteNamed('ver.edital.vigente') ? 'active' : '' }}"><a href="{{ route('ver.edital.vigente') }}">{{trans('tela_ver_edital_vigente.tela_edital_vigente')}}</a></li>
        <li class="{{ Route::currentRouteNamed('dados.pessoais') ? 'active' : '' }}"><a href="{{ route('dados.pessoais') }}">{{trans('tela_dados_pessoais.tela_dados_pessoais')}}</a></li>
        @liberamenu(Auth()->user())
        <li class="{{ Route::currentRouteNamed('dados.academicos') ? 'active' : '' }}"><a href="{{ route('dados.academicos') }}">{{ trans('tela_dados_academicos.tela_dados_academicos') }}</a></li>
        <li class="{{ Route::currentRouteNamed('dados.escolhas') ? 'active' : '' }}"><a href="{{ route('dados.escolhas') }}">{{ trans('tela_escolha_candidato.tela_escolhas') }}</a></li>
        <li class="{{ Route::currentRouteNamed('motivacao.documentos') ? 'active' : '' }}"><a href="{{ route('motivacao.documentos') }}">{{ trans('tela_motivacao_documentos.tela_motivacao_documentos') }}</a></li>
        @endliberamenu
        @statuscarta
          <li class="{{ Route::currentRouteNamed('status.cartas') ? 'active' : '' }}"><a href="{{ route('status.cartas') }}">{{ trans('tela_status_cartas.status_cartas') }}</a></li>
        @endstatuscarta
        @confirmacao_participacao
            <li class="{{ Route::currentRouteNamed('confirma.presenca') ? 'active' : '' }}"><a href="{{ route('confirma.presenca') }}">{{ trans('tela_confirma_presenca.confirma_presenca') }}</a></li>
          @endconfirmacao_participacao
          @envia_documentos_matricula
            <li class="{{ Route::currentRouteNamed('envia.documentos.matricula') ? 'active' : 'active_destaque' }}"><a style="{{ Route::currentRouteNamed('envia.documentos.matricula') ? '' : 'color:red' }}" href="{{ route('envia.documentos.matricula') }}">{{ trans('tela_envia_documentos_matricula.documentos_matricula') }}</a></li>
          @endenvia_documentos_matricula
        <li class="{{ Route::currentRouteNamed('auth.logout') ? 'active' : '' }}"><a href="{{ route('auth.logout') }}">{{ trans('tela_sair.sair') }}</a></li>
        @impersonating_candidato
          <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('impersonating').submit();">Voltar ao Admin</a>
          </li>

          {!! Form::open(array('route' => 'admin.impersonate', 'id' => 'impersonating', 'class' => 'hidden')) !!}
            {{ method_field('DELETE') }}
          {!! Form::close() !!}

        @endimpersonating_candidato
      </ul>
    </div>
  </nav>
</div>
