@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('acha_indicacoes')
@if ($modo_pesquisa)
	{!! Form::open(array('route' => 'pesquisa.indicacoes', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
@endif

<div class="row">
	<div class="form-group">
		{!! Form::label('email_recomendante', 'Pesquisar Recomendante', ['class' => 'col-md-4 control-label']) !!}
		<div class="col-md-4">
			{!! Form::text('email_recomendante', '' , ['class' => 'form-control input-md']) !!}
		</div>
	</div>	
</div>


@if (!$modo_pesquisa)
	
	<fieldset class="scheduler-border">
  <legend class="scheduler-border">Fichas de Inscrição Individuais</legend>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Nome do Candidato</th>
          <th>E-mail</th>
          <th>Programa</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $indicacoes as $indicado)
          <tr class="">
            <td>{{ $indicado->nome }}</td>
            <td>{{ $indicado->email }}</td>
            <td>{{ $indicado->tipo_programa_pos }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="text-center">
    {{ $indicacoes->render() }}
  </div>
</fieldset>
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
	{!! Form::open(array('route' => 'pesquisa.indicacoes', 'class' => 'form-horizontal', 'method' => 'get')) !!}
	<div class="form-group">
	  <div class="row">
	    <div class="col-md-6 col-md-offset-3 text-center">
	      {!! Form::submit('Nova Pesquisa', ['class' => 'btn btn-primary btn-lg register-submit']) !!}
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