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

        <div class="col-xs-12" style="height:35px;"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
              <input type="submit" name="registrar" id="register-submit" class="btn btn-primary btn-lg" tabindex="4" value="Criar conta">
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
