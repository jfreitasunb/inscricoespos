@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('dados_coordenador_pos')
  <div class="row">
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">Dados do(a) Coordenador(a) da Pós-Graduação do MAT/UnB</legend>
      {!! Form::open(array('route' => 'dados.coordenador.pos', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}  
        <div class="form-group">
          {!! Form::label('nome_coordenador', 'Nome do(a) Coordenador(a)', ['class' => 'col-md-4 control-label']) !!}
          <div class="col-md-6">
            {!! Form::text('nome_coordenador', '', ['class' => 'form-control input-md']) !!}
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('prof_tratamento', 'Forma de Tratamento', ['class' => 'col-md-4 control-label']) !!}
          <div class="col-md-6">
            {!! Form::radio('prof_tratamento', 'Prof.', ['class' => 'form-control input-md']) !!} Prof.
            {!! Form::radio('prof_tratamento', 'Profa.', ['class' => 'form-control input-md']) !!} Profa.
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('tipo_coord', 'Tipo', ['class' => 'col-md-4 control-label']) !!}
          <div class="col-md-6">
            {!! Form::radio('tipo_coord', 'Coordenador', ['class' => 'form-control input-md']) !!} Coordenador
            {!! Form::radio('tipo_coord', 'Coordenadora', ['class' => 'form-control input-md']) !!} Coordenadora
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
    </fieldset>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/parsley.min.js') }}"></script>
  <script src="{{ asset('i18n/pt-br.js') }}"></script>
@endsection
