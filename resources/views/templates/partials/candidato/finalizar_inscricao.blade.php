@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('finaliza_inscricao')
{!! Form::open(array('route' => 'finalizar.inscricao', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
      
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.motivacao')}}</legend>
      <div class="row">
        <div class="col-md-12">
          {!! Form::textarea('motivacao',null , ['class' => 'form-control', 'rows' => '15', 'required' => '']) !!} 
        </div>
      </div>
  </fieldset>

      <div class="form-group">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            {!! Form::submit(trans('tela_escolha_candidato.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
