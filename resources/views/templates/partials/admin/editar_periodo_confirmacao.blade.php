@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('editar_periodo_confirmacao')
{!! Form::open(array('route' => 'editar.periodo.confirmacao', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}

{!! Form::hidden('id_inscricao_pos', $id_inscricao_pos, []) !!}

<label>1 -> Mestrado, 2 -> Doutorado, 1_2 -> Ambos</label>

@foreach ($periodo_confirmacao as $periodo)
  <div class="form-group">
    {!! Form::label('inicio_inscricao', 'Mês de Início na Pós', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('mes_inicio_inscricao_'.$periodo->id_inicio_programa, $periodo->mes_inicio, ['class' => 'form-control input-md']) !!}
    </div>
  </div>
  <div class="form-group">
    {!! Form::label('fim_inscricao', 'Fim da Confirmação', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('fim_confirmacao_'.$periodo->id_inicio_programa, $periodo->prazo_confirmacao , ['class' => 'form-control input-md']) !!}
    </div>
  </div>
  <div class="form-group">
    {!! Form::label('programa_para_confirmar', 'Programa da Pós', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('programa_para_confirmar_'.$periodo->id_inicio_programa, $periodo->programa_para_confirmar , ['class' => 'form-control input-md']) !!}
    </div>
  </div>
  <hr>
@endforeach
<div class="form-group">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
      {!! Form::submit('Salvar', ['class' => 'btn btn-primary btn-lg register-submit']) !!}
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
  {{-- {!! Html::script( asset('js/datepicker.js') ) !!} --}}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection