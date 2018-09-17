@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('configurar_periodo_confirmacao')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      {!! Form::open(array('route' => 'configura.inscricao','data-parsley-validate' => '' ,'enctype' => 'multipart/form-data')) !!}
        <legend>Configurar o(s) período(s) de confirmação para o edital n<sup>o</sup> <strong>{{ $edital }}</strong></legend>
        <div class="col-xs-6">
          <div class="form-group form-inline">
            {!! Form::label('mes_inicio_1', 'Mês de início no programa:') !!}
            <div class='input-group' id='mes_inicio_1'>
              {!! Form::text('mes_inicio_1', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group form-inline">
            {!! Form::label('prazo_confirmacao_mes_1', 'Prazo para confirmação de interesse:') !!}
            <div class='input-group' id='prazo_confirmacao_mes_1'>
              {!! Form::text('prazo_confirmacao_mes_1', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group form-inline">
            {!! Form::label('mes_inicio_2', 'Mês de início no programa:') !!}
            <div class='input-group' id='mes_inicio_2'>
              {!! Form::text('mes_inicio_2', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group form-inline">
            {!! Form::label('prazo_confirmacao_mes_2', 'Prazo para confirmação de interesse:') !!}
            <div class='input-group' id='prazo_confirmacao_mes_2'>
              {!! Form::text('prazo_confirmacao_mes_2', null, ['class' => 'form-control']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-10 text-center"> 
          {!! Form::submit('Salvar', array('class' => 'register-submit btn btn-primary btn-lg', 'id' => 'register-submit', 'tabindex' => '4')) !!}
        </div>
    </div>
    {!! Form::close() !!}
  </div>
@endsection

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection
