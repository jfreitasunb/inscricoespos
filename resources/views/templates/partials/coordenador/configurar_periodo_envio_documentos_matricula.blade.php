@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('configurar_periodo_envio_documentos_matricula')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      {!! Form::open(array('route' => 'configura.periodo.confirmacao','data-parsley-validate' => '' ,'enctype' => 'multipart/form-data')) !!}
        <legend>Configurar o período de envio dos documentos de matrícula para os(as) candidatos(as) selecionados(as) no edital n<sup>o</sup> <strong>{{ $edital }}</strong></legend>
        <div class="col-xs-6">
          <div class="form-group form-inline">
            {!! Form::label('inicio_entrega', 'Início:') !!}
            <div class='input-group' id='inicio_entrega'>
              {!! Form::text('inicio_entrega', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group form-inline">
            {!! Form::label('fim_entrega', 'Fim:') !!}
            <div class='input-group' id='fim_entrega'>
              {!! Form::text('fim_entrega', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-10 text-center">
          {!! Form::hidden('id_inscricao_pos', $edital_vigente->id_inscricao_pos, []) !!}
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
