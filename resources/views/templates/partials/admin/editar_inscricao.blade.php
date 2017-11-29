@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('editar_inscricao')
{!! Form::open(array('route' => 'editar.inscricao', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}

{!! Form::hidden('id_inscricao_pos', $edital_vigente->id_inscricao_pos, []) !!}

<div class="form-group">
	{!! Form::label('inicio_inscricao', 'Início da Inscrição', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-4">
		{!! Form::text('inicio_inscricao', $edital_vigente->inicio_inscricao, ['class' => 'form-control input-md']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('fim_inscricao', 'Início da Inscrição', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-4">
		{!! Form::text('fim_inscricao', $edital_vigente->fim_inscricao, ['class' => 'form-control input-md']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('prazo_carta', 'Prazo da Carta', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-4">
		{!! Form::text('prazo_carta', $edital_vigente->prazo_carta, ['class' => 'form-control input-md']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('programa', 'Programas para inscrição', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-4">
		{!! Form::text('programa', $edital_vigente->programa, ['class' => 'form-control input-md']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('edital', 'Edital', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-4">
		{!! Form::text('edital', $edital_vigente->edital, ['class' => 'form-control input-md']) !!}
	</div>
</div>
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