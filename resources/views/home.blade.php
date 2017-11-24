@extends('templates.default')

@section('inicio')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="idiomas btn-toolbar">
        <div class="btn-group btn-group-justified">
          <a href="{{ route('lang.portuguese') }}" class="btn btn-primary">Português</a>
          <a href="{{ route('lang.english') }}" class="btn btn-primary">English</a>
          <a href="{{ route('lang.spanish') }}" class="btn btn-primary">Spañol</a>
        </div>  
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-login">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6">
              <a href="{{ route('auth.login') }}">Login</a>
            </div>
            <div class="col-xs-6">
              <a href="{{ route('auth.registrar') }}">{{trans('tela_inicial.menu_registrar')}}</a>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-center">
                <a href="{{ route('password.request') }}" tabindex="5" class="forgot-password">{{trans('tela_login.menu_esqueceu_senha')}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
  <p class="bottom-three">
   
  </p>
@stop