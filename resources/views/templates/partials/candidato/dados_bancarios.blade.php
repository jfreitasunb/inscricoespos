@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('dados_bancarios')
  <div class="row">
    <form data-parsley-validate="" class="form-horizontal" action="" method="post">
      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Dados Bancários</legend>
        
        <div class="form-group" {{ $errors->has('nome_banco') ? ' has-error' : '' }}>
          <div class="row">
            <label class="col-md-4 control-label" for="nome_banco">Banco</label>  
            <div class="col-md-4">
              <input id="nome_banco" name="nome_banco" type="text" class="form-control input-md" required="" value="{{$dados['nome_banco'] or Request::old('nome_banco') ?: '' }}">
            </div>
          </div>
          @if ($errors->has('nome_banco'))
            <span class="help-block">{{ $errors->first('nome_banco') }}</span>
          @endif
        </div>

        <div class="form-group" {{ $errors->has('numero_banco') ? ' has-error' : '' }}>
          <div class="row">
            <label class="col-md-4 control-label" for="numero_banco">Número do banco</label>  
            <div class="col-md-4">
              <input id="numero_banco" name="numero_banco" type="text" class="form-control input-md" required="" value="{{$dados['numero_banco'] or Request::old('numero_banco') ?: '' }}">
            </div>
          </div>
          @if ($errors->has('numero_banco'))
            <span class="help-block">{{ $errors->first('numero_banco') }}</span>
          @endif
        </div>

        <div class="form-group" {{ $errors->has('agencia_bancaria') ? ' has-error' : '' }}>
          <div class="row">
            <label class="col-md-4 control-label" for="agencia_bancaria">Agência</label>  
            <div class="col-md-4">
              <input id="agencia_bancaria" name="agencia_bancaria" type="text" placeholder="" class="form-control input-md" required="" value="{{$dados['agencia_bancaria'] or Request::old('agencia_bancaria') ?: '' }}">
            </div>
          </div>
          @if ($errors->has('agencia_bancaria'))
            <span class="help-block">{{ $errors->first('agencia_bancaria') }}</span>
          @endif
        </div>

        <div class="form-group" {{ $errors->has('numero_conta_corrente') ? ' has-error' : '' }}>
          <div class="row">
            <label class="col-md-4 control-label" for="numero_conta_corrente">Conta corrente</label>  
            <div class="col-md-4">
              <input id="numero_conta_corrente" name="numero_conta_corrente" type="text" placeholder="" class="form-control input-md" required="" value="{{$dados['numero_conta_corrente'] or Request::old('numero_conta_corrente') ?: '' }}">
            </div>
          </div>
          @if ($errors->has('numero_conta_corrente'))
            <span class="help-block">{{ $errors->first('numero_conta_corrente') }}</span>
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
