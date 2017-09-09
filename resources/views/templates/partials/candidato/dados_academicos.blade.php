@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('dados_academicos')
  <form data-parsley-validate="" action="" method="POST" class="form-group" enctype="multipart/form-data">
      <fieldset class="scheduler-border">
        <!-- BEGIN ano_semestre_ira -->
        <legend class="scheduler-border">IRA atualizado ({{$ano_semestre_ira}})</legend>
        <!-- END ano_semestre_ira -->
        <div class="form-horizontal"{{ $errors->has('nome') ? ' has-error' : '' }}>
          <div class="row">
            <div class="col-md-4 form-group">
              <input id="ira" name="ira" type="text" class="form-control" required="" value="{{$dados['ira'] or Request::old('ira') ?: '' }}">
            </div>
          </div>
        </div>
      </fieldset>

      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Curso de Graduação</legend>
        <div class="form-horizontal{{ $errors->has('nome') ? ' has-error' : '' }}">
          <p>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="matematica" required="" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "matematica") or  Request::old('curso_graduacao')=="matematica") checked @endif> Matemática (Bacharelado/Licenciatura)<br>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="computacao" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "computacao") or Request::old('curso_graduacao')=="computacao") checked @endif> Ciências da Computação (Bacharelado/Licenciatura)<br>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="estatistica" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "estatistica") or Request::old('curso_graduacao')=="estatistica") checked @endif> Estatística<br>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="fisica" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "fisica") or Request::old('curso_graduacao')=="fisica") checked @endif> Física (Bacharelado/Licenciatura)<br>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="quimica" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "quimica") or Request::old('curso_graduacao')=="quimica") checked @endif> Química (Bacharelado/Licenciatura)<br>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="geologia_geofisica" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "geologia_geofisica") or Request::old('curso_graduacao')=="geologia_geofisica") checked @endif> Geologia/Geofísica<br>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="engenharia" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "engenharia") or Request::old('curso_graduacao')=="engenharia") checked @endif> Engenharia (Mecânica/Elétrica/Civil/Redes/Mecatrônica/Química/Produção)<br>
            <input type="radio" name="curso_graduacao" id="curso_graduacao" value="outros" @if((array_key_exists('curso_graduacao',$dados) AND $dados['curso_graduacao'] == "outros") or Request::old('curso_graduacao')=="outros") checked @endif> Outros<br>
          </p>
        </div>
        @if ($errors->has('nome'))
          <span class="help-block">{{ $errors->first('nome') }}</span>
        @endif
      </fieldset>

      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Você já foi monitor de disciplinas do Departamento de Matemática?</legend>
        <div class="form-horizontal"{{ $errors->has('nome') ? ' has-error' : '' }} required="">
          <div class="row">
            <p>
              <input type="checkbox" name="checkbox_foi_monitor[]" id="checkbox_foi_monitor" value="calculo1_matematica1" @if(is_array(Request::old('checkbox_foi_monitor')) && in_array("calculo1_matematica1",Request::old('checkbox_foi_monitor'))) checked @endif required=""> Sim, de Cálculo 1 ou Matemática 1<br>
            
              <input type="checkbox" name="checkbox_foi_monitor[]" id="checkbox_foi_monitor" value="calculo2_matematica_2" @if(is_array(Request::old('checkbox_foi_monitor')) && in_array("calculo2_matematica_2",Request::old('checkbox_foi_monitor'))) checked @endif> Sim, de Cálculo 2 ou Matemática 2<br>
            
              <input type="checkbox" name="checkbox_foi_monitor[]" id="checkbox_foi_monitor" value="calculo3" @if(is_array(Request::old('checkbox_foi_monitor')) && in_array("calculo3",Request::old('checkbox_foi_monitor'))) checked @endif> Sim, de Cálculo 3<br>
            
              <input type="checkbox" name="checkbox_foi_monitor[]" id="checkbox_foi_monitor" value="ial_algebra-linear" @if(is_array(Request::old('checkbox_foi_monitor')) && in_array("ial_algebra-linear",Request::old('checkbox_foi_monitor'))) checked @endif> Sim, de Introdução à Álgebra Linear ou Álgebra Linear<br>
            
              <input type="checkbox" name="checkbox_foi_monitor[]" id="checkbox_foi_monitor" value="outras" @if(is_array(Request::old('checkbox_foi_monitor')) && in_array("outras",Request::old('checkbox_foi_monitor'))) checked @endif> Sim, de outras disciplinas<br>
            
              <input type="checkbox" name="checkbox_foi_monitor[]" id="checkbox_foi_monitor" value="nao" @if(is_array(Request::old('checkbox_foi_monitor')) && in_array("nao",Request::old('checkbox_foi_monitor'))) checked @endif> Não<br>
            </p>
          </div>
           @if ($errors->has('nome'))
            <span class="help-block">{{ $errors->first('nome') }}</span>
          @endif
        </div>
      </fieldset>

      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Histórico</legend>
        <div class="form-horizontal"{{ $errors->has('nome') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf, image/png, image/jpeg, image/jpg, image/gif" name="arquivo" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('nome'))
            <span class="help-block">{{ $errors->first('nome') }}</span>
          @endif
        </div>
      </fieldset>

      <div class="col-xs-12" style="height:35px;"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
              <input type="submit" name="registrar" id="register-submit" class="btn btn-primary btn-lg" tabindex="4" value="Enviar" {desativa_registro}>
            </div>
          </div>
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
@endsection

@section('scripts')
  <script src="{{ asset('js/parsley.min.js') }}"></script>
  <script src="{{ asset('i18n/pt-br.js') }}"></script>
@endsection
