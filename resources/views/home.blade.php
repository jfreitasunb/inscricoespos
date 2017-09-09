@extends('templates.default')

@section('inicio')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-login">
      <div class="row col-md-offset-2">
        <div class="col-xs-3">
           <a href="{{ route('lang.portuguese') }}">Português</a>
        </div>
        <div class="col-xs-3">
           <a href="{{ route('lang.english') }}">English</a>
        </div>
        <div class="col-xs-3">
           <a href="{{ route('lang.spanish') }}">Español</a>
        </div>
      </div>
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6">
              <a href="{{ route('auth.login') }}">Login</a>
            </div>
            <div class="col-xs-6">
              <a href="{{ route('auth.registrar') }}">Registrar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <p class="bottom-three">
   
  </p>
@stop