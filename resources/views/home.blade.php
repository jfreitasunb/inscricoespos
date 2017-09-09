@extends('templates.default')

@section('inicio')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-login">
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