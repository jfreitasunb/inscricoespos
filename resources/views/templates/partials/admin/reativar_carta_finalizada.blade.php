@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('reativar_carta_enviada')
@if ($modo_pesquisa)
	{!! Form::open(array('route' => 'pesquisa.carta', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
@endif

<div class="row">
	<div class="form-group">
		{!! Form::label('email_recomendante', 'Pesquisar Carta', ['class' => 'col-md-4 control-label']) !!}
		<div class="col-md-4">
			{!! Form::text('email_recomendante', '' , ['class' => 'form-control input-md']) !!}
		</div>
	</div>
</div>
<hr>

@if (!$modo_pesquisa)
	@foreach ($cartas_completadas as $carta)
	{!! Form::open(array('route' => 'reativar.carta', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}

	{!! Form::hidden('id_inscricao_pos', $carta->id_inscricao_pos, []) !!}
	{!! Form::hidden('id_aluno', $carta->id_aluno, []) !!}
	{!! Form::hidden('id_recomendante', $carta->id_prof, []) !!}
	
	<div class="row">
		<div class="form-group">
			<div class="col-md-1">
				{!! Form::label('nome_candidato', 'Nome', ['class' => 'control-label']) !!}
			</div>
      		<div class="col-md-3">
      			{!! Form::text('nome_candidato', $carta->nome, ['class' => 'form-control']) !!}
      		</div>
      		<div class="col-md-1">
				{!! Form::label('programa', 'Programa', ['class' => 'control-label']) !!}
			</div>
      		<div class="col-md-2">
      			{!! Form::text('programa', $carta->tipo_programa_pos_ptbr, ['class' => 'form-control']) !!}
      		</div>
      		<div class="col-md-2">
				{!! Form::label('completada', 'Carta enviada?', ['class' => 'control-label']) !!}
			</div>
      		<div class="col-md-1">
      			{!! Form::text('completada', $carta->completada ? 'Sim' : 'Não', ['class' => 'form-control']) !!}
      		</div>
      		<div class="col-md-2">
      			{!! Form::submit('Alterar', ['class' => 'btn btn-danger pull-righ']) !!}
      		</div>
    	</div>
	</div>
	<hr>
		
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
	{!! Form::open(array('route' => 'reativar.carta', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}	
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