@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('dados_pessoais')
<div class="row">
  <form data-parsley-validate="" class="form-horizontal" action="" method="post">
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">Dados Pessoais</legend>

      <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="nome">Nome</label>  
          <div class="col-md-4">
            <input id="nome" name="nome" type="text" class="form-control input-md" value="{{$dados['nome'] or Request::old('nome') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('nome'))
          <span class="help-block">{{ $errors->first('nome') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('numerorg') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="numerorg">RG</label>  
          <div class="col-md-4">
            <input id="numerorg" name="numerorg" type="text" class="form-control input-md" required="" data-parsley-type="alphanum" data-parsley-maxlength="20" value="{{$dados['numerorg'] or Request::old('numerorg') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('numerorg'))
          <span class="help-block">{{ $errors->first('numerorg') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('emissorrg') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="emissorrg">Órgão Emissor</label>  
          <div class="col-md-4">
            <input id="emissorrg" name="emissorrg" type="text" class="form-control input-md" required="required" data-parsley-maxlength="200" value="{{$dados['emissorrg'] or Request::old('emissorrg') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('emissorrg'))
          <span class="help-block">{{ $errors->first('emissorrg') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="cpf">CPF</label>  
          <div class="col-md-4">
            <input id="cpf" name="cpf" type="text" placeholder="Somente números" class="form-control input-md" required="required" data-parsley-maxlength="13" data-parsley-type="digits" value="{{$dados['cpf'] or Request::old('cpf') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('cpf'))
          <span class="help-block">{{ $errors->first('cpf') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="endereco">Endereço</label>  
          <div class="col-md-4">
            <input id="endereco" name="endereco" type="text" placeholder="" class="form-control input-md" required="" data-parsley-maxlength="255" value="{{$dados['endereco'] or Request::old('endereco') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('endereco'))
          <span class="help-block">{{ $errors->first('endereco') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="cidade">Cidade</label>  
          <div class="col-md-4">
            <input id="cidade" name="cidade" type="text" placeholder="" class="form-control input-md" required="" data-parsley-maxlength="100" value="{{$dados['cidade'] or Request::old('cidade') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('cidade'))
          <span class="help-block">{{ $errors->first('cidade') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="cep">CEP</label>  
          <div class="col-md-4">
            <input id="cep" name="cep" type="text" placeholder="" class="form-control input-md" required="" data-parsley-maxlength="11" value="{{$dados['cep'] or Request::old('cep') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('cep'))
          <span class="help-block">{{ $errors->first('cep') }}</span>
        @endif --}}
      </div>

        <div class="row">
          <label class="col-md-4 control-label" for="estado">Estado</label>  
          <div class="col-md-4">
            <input id="estado" name="estado" type="text" placeholder="Sigla" class="form-control input-md" required="" data-parsley-maxlength="3" value="{{$dados['estado'] or Request::old('estado') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('estado'))
          <span class="help-block">{{ $errors->first('estado') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="telefone">Telefone</label>  
          <div class="col-md-4">
            <input id="telefone" name="telefone" type="text" placeholder="(DD)#######" class="form-control input-md" required="" data-parsley-maxlength="20" value="{{$dados['telefone'] or Request::old('telefone') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('telefone'))
          <span class="help-block">{{ $errors->first('telefone') }}</span>
        @endif --}}
      </div>

      <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
        <div class="row">
          <label class="col-md-4 control-label" for="celular">Celular</label>  
          <div class="col-md-4">
            <input id="celular" name="celular" type="text" placeholder="(DD)#######" class="form-control input-md" required="" data-parsley-maxlength="20" value="{{$dados['celular'] or Request::old('celular') ?: '' }}">
          </div>
        </div>
        {{-- @if ($errors->has('celular'))
          <span class="help-block">{{ $errors->first('celular') }}</span>
        @endif --}}
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

{{-- @section('post-script')
    <script type="text/javascript">
        $('select[name=estado]').change(function () {
            var idEstado = $(this).val();

            $.get('/get-cidades/' + idEstado, function (cidades) {
                $('select[name=cidade]').empty();
                $.each(cidades, function (key, value) {
                    $('select[name=cidade]').append('<option value=' + value.id + '>' + value.cidade + '</option>');
                });
            });
        });

    </script>
@endsection
 --}}

