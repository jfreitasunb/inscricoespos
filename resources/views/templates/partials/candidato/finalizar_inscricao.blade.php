@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('finaliza_inscricao')
{!! Form::open(array('route' => 'finalizar.inscricao', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
      
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_finalizar_inscricao.tela_finaliza')}}</legend>
      <div class="row">
        {{ trans('tela_finalizar_inscricao.texto_finaliza') }}
      </div>
  </fieldset>

  

      <div class="form-group">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            {!! Form::submit(trans('tela_finalizar_inscricao.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
