@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('carta_parte_inicial')

{!! Form::open(array('route' => 'preencher.carta', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_carta_parte_inicial.tela_pendentes')}}</legend>

  <div class="row">
    {!! Form::label('tempo_conhece_candidato', trans('tela_carta_parte_inicial.tempo_conhece_candidato'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::text('tempo_conhece_candidato', $dados['tempo_conhece_candidato'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('circunstancia', trans('tela_carta_parte_inicial.circunstancia'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::checkbox('circunstancia_1', 'Aula', $dados['circunstancia_1'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_1') }}
    {!! Form::checkbox('circunstancia_2', 'Orientação', $dados['circunstancia_2'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_2') }}
    {!! Form::checkbox('circunstancia_3', 'Seminários', $dados['circunstancia_3'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_3') }}
    {!! Form::checkbox('circunstancia_4', 'Outra', $dados['circunstancia_4'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_4') }}
    {!! Form::text('circunstancia_outra',  $dados['circunstancia_outra'] ?: '', [ 'class' => 'form-control form-inline'] ) !!}
    </div>
  </div>

  <strong><p>{{ trans('tela_carta_parte_inicial.tabela_avaliacao') }}</p></strong>


 
</fieldset>
<div class="form-group">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
      {!! Form::submit(trans('tela_carta_parte_inicial.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
    </div>
  </div>
</div>
{!! Form::close() !!}

@endsection

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection