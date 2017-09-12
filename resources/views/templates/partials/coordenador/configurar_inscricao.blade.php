@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('configura_inscricao')
  <form action="{{ route('configura.inscricao') }}" method="POST" data-parsley-validate enctype="multipart/form-data">
    <legend>Configurar período da abertura da inscrição</legend>
    <div class="row">
      <div class='col-xs-4'>
          <div class="form-group form-inline">
              <label for="">Início da Inscrição:</label>
              <div class='input-group' id='inicio_inscricao'>
                  <input type='text' class="form-control{{ $errors->has('inicio_inscricao') ? ' has-error' : '' }}" name="inicio_inscricao" value="{{ Request::old('inicio_inscricao') ?: '' }}" required/>
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
              @if ($errors->has('inicio_inscricao'))
                      <span class="help-block">{{ $errors->first('inicio_inscricao') }}</span>
                @endif
          </div>
      </div>
      <div class='col-xs-4'>
          <div class="form-group form-inline">
              <label for="">Final da Inscrição:</label>
              <div class='input-group date' id='fim_inscricao'>
                  <input type='text' class="form-control{{ $errors->has('fim_inscricao') ? ' has-error' : '' }}" name="fim_inscricao" value="{{ Request::old('fim_inscricao') ?: '' }}"/>
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
              @if ($errors->has('fim_inscricao'))
                      <span class="help-block">{{ $errors->first('fim_inscricao') }}</span>
                @endif
          </div>
      </div>
    </div>
    <div class="row">
      <div class='col-xs-4'>
          <div class="form-group form-inline">
              <label for="">Data limite para envio das cartas de recomendação:</label>
              <div class='input-group date' id='data_envio_carta_recomendacao'>
                  <input type='text' class="form-control{{ $errors->has('data_envio_carta_recomendacao') ? ' has-error' : '' }}" name="data_envio_carta_recomendacao" value="{{ Request::old('data_envio_carta_recomendacao') ?: '' }}"/>
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
              @if ($errors->has('data_envio_carta_recomendacao'))
                      <span class="help-block">{{ $errors->first('data_envio_carta_recomendacao') }}</span>
                @endif
          </div>
      </div>
    </div>


    <legend>Definir Ano e Semestre de Admissão</legend>
    <div class="row">
      <div class="col-xs-4">
        <div class="form-group form-inline{{ $errors->has('semestre') ? ' has-error' : '' }}">
        <label for="">Ano de admissão: </label>
          <input type="text" name="ano_admissao" id="ano_admissao" required="" value="{{Request::old('ano_admissao') ?: '' }}">
        </div>
      </div>
      <div class="col-xs-4">
        <div class="form-group form-inline{{ $errors->has('semestre') ? ' has-error' : '' }}">
        <label for="">Semestre de admissão: </label>
          <input type="radio" name="semestre" id="semestre" class="radio" value="1" @if(Request::old('semestre')==1) checked @endif> 1
          <input type="radio" name="semestre" id="semestre" class="radio" value="2" @if(Request::old('semestre')==2) checked @endif> 2
        </div>
      </div> 
    </div>

    <legend>Escolher os programas para Inscrição:</legend>
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group form-inline{{ $errors->has('escolhas_coordenador') ? ' has-error' : '' }}">
        @if ($errors->has('escolhas_coordenador'))
          <span class="help-block">Você deve escolher pelo menos 01(uma) programa.</span>
        @endif
          @foreach($programas_pos_mat as $programa)
          <input type="checkbox" id="programa" name="escolhas_coordenador[]" class="checkbox" value="{{ $programa->id_programa_pos }}"> {{ $programa->tipo_programa_pos }}
          @endforeach
        </div>
      </div>
    </div>
  
    <legend>Edital</legend>
    <div class="form-horizontal"{{ $errors->has('edital') ? ' has-error' : '' }}>
    <div class="row">
      <div class="col-xs-4">
        <div class="form-group form-inline{{ $errors->has('semestre') ? ' has-error' : '' }}">
        <label for="">Ano: </label>
          <input type="text" name="ano_edital" id="ano_edital" required="" value="{{Request::old('ano_edital') ?: '' }}">
        </div>
      </div> 
      <div class="row">
      <div class="col-xs-4">
        <div class="form-group form-inline{{ $errors->has('semestre') ? ' has-error' : '' }}">
        <label for="">Número: </label>
          <input type="text" name="ano_edital" id="ano_edital" required="" value="{{Request::old('ano_edital') ?: '' }}">
        </div>
      </div> 
    </div>
      <div class="row">
        <span class="input-group-btn">
            <!-- image-preview-clear button -->
            <button type="button" class="btn btn-primary" style="display:none;">
                <span class="glyphicon glyphicon-remove"></span> Clear
            </button>
            <!-- image-preview-input -->
            <div class="btn btn-primary">
                <input type="file" accept="application/pdf" name="edital" required=""/> <!-- rename it -->
            </div>
        </span>
      </div>
       @if ($errors->has('edital'))
        <span class="help-block">{{ $errors->first('edital') }}</span>
      @endif
    </div>

    <div id="hidden_form_container" style="display:none;"></div>
    <div class="col-xs-12" style="height:35px;"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
              <input type="submit" name="registrar" id="register-submit" class="btn btn-primary btn-lg" tabindex="4" value="Enviar">
            </div>
          </div>
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
  </form>

  <div id="result"></div>
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/moment/min/moment.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/moment/locale/pt-br.js')}}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
  <link rel="stylesheet" href="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
  <script src="{{ asset('bower_components/moment/locale/fr.js')}}"></script>
  <script type="text/javascript" src="{{ asset('js/datepicker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/parsely.min.js') }}"></script>
@endsection
