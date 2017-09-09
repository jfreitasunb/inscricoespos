@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('cadastra_disciplina')
  <div class="row">
    <form action="{{ route('cadastra.disciplina') }}" method="POST" data-parsley-validate class="form-horizontal">
      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Cadastrar nova disciplina</legend>
        
        <div class="form-group" {{ $errors->has('codigo') ? ' has-error' : '' }}>
          <div class="row">
            <label class="col-md-4 control-label" for="codigo">Código disciplina</label>  
            <div class="col-md-2">
              <input id="codigo" name="codigo" type="text" class="form-control input-md" required="" data-parsley-type="number" value="{{Request::old('codigo') ?: '' }}">
            </div>
          </div>
          @if ($errors->has('codigo'))
            <span class="help-block">{{ $errors->first('codigo') }}</span>
          @endif
        </div>

        <div class="form-group" {{ $errors->has('nome_disciplina') ? ' has-error' : '' }}>
          <div class="row">
            <label class="col-md-4 control-label" for="nome_disciplina">Nome da disciplina</label>  
            <div class="col-md-4">
              <input id="nome_disciplina" name="nome_disciplina" type="text" class="form-control input-md" required="" value="{{Request::old('nome_disciplina') ?: '' }}">
            </div>
          </div>
          @if ($errors->has('nome_disciplina'))
            <span class="help-block">{{ $errors->first('nome_disciplina') }}</span>
          @endif
        </div>

        <div class="form-group" {{ $errors->has('creditos_disciplina') ? ' has-error' : '' }}>
          <div class="row">
            <label class="col-md-4 control-label" for="creditos_disciplina">Créditos</label>  
            <div class="col-md-1">
              <input id="creditos_disciplina" name="creditos_disciplina" type="text" placeholder="" class="form-control input-md" required="" data-parsley-type="number" value="{{Request::old('creditos_disciplina') ?: '' }}">
            </div>
          </div>
          @if ($errors->has('creditos_disciplina'))
            <span class="help-block">{{ $errors->first('creditos_disciplina') }}</span>
          @endif
        </div>

        <div class="col-xs-12" style="height:35px;"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
              <input type="submit" name="registrar" id="register-submit" class="btn btn-primary btn-lg" tabindex="4" value="Enviar">
            </div>
          </div>
        </div>
      </fieldset>
      <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/parsley.min.js') }}"></script>
  <script src="{{ asset('i18n/pt-br.js') }}"></script>
@endsection
