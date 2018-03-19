@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('acha_indicacoes')
@if ($modo_pesquisa)
	{!! Form::open(array('route' => 'pesquisa.recomendantes', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
@endif

<div class="form-group">
	{!! Form::label('email_candidato', 'Pesquisar Recomendante', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-4">
		{!! Form::text('email_candidato', '' , ['class' => 'form-control input-md']) !!}
	</div>
</div>

@if (!$modo_pesquisa)
	<div class="form-group">
		<div class="col-sm-6">
			<input class="form-control" type="text" name="" value="{{ $candidato['nome'] }}" readonly="readonly">
		</div>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="" value="{{ $candidato['programa'] }}" readonly="readonly">
		</div>
		<div class="col-sm-2">
			<input class="form-control" type="text" name="" value="{{ $candidato['edital'] }}" readonly="readonly">
		</div>
	</div>

	@foreach ($array_recomendantes as $key => $recomendante)
	{!! Form::open(array('route' => 'altera.recomendante', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}

	{!! Form::hidden('id_inscricao_pos', $candidato['id_inscricao_pos'], []) !!}
	{!! Form::hidden('id_aluno', $candidato['id_aluno'], []) !!}
		{!! Form::hidden('id', $recomendante['id'], []) !!}
		{!! Form::hidden('id_recomendante', $key, []) !!}
		{!! Form::hidden('nome_candidato', $candidato['nome'], []) !!}
		{!! Form::hidden('programa', $candidato['programa'], []) !!}


		<div class="form-group">
			<div class="col-sm-1">
				{!! Form::label('nome_recomendante', 'Nome', ['class' => 'control-label']) !!}
			</div>
      		<div class="col-sm-4">
      			{!! Form::text('nome_recomendante', $recomendante['nome_recomendante'], ['class' => 'form-control']) !!}
      		</div>
      		<div class="col-sm-1">
				{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
			</div>
      		<div class="col-sm-4">
      			{!! Form::text('email_recomendante', $recomendante['email_recomendante'], ['class' => 'form-control']) !!}
      		</div>
      		<div class="col-sm-2">
      			{!! Form::submit('Alterar', ['class' => 'btn btn-danger pull-righ']) !!}
      		</div>
    	</div>
    	{!! Form::close() !!}
	@endforeach
@endif

@if ($modo_pesquisa)
	<div class="form-group">
	  <div class="row">
	    <div class="col-md-6 col-md-offset-3 text-center">
	      {!! Form::submit('Pesquisar', ['class' => 'btn btn-primary btn-lg register-submit']) !!}
	    </div>
	  </div>
	</div>
	{!! Form::close() !!}
@else
	{!! Form::open(array('route' => 'altera.recomendante', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}	
	<div class="form-group">
	  <div class="row">
	    <div class="col-md-6 col-md-offset-3 text-center">
	      {!! Form::submit('Cancelar', ['class' => 'btn btn-primary btn-lg register-submit', 'name' =>'cancelar', 'value' => '0']) !!}
	    </div>
	  </div>
	</div>
	{!! Form::close() !!}
@endif


@endsection

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection