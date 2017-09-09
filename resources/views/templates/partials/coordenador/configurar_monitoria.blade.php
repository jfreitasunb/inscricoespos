@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('configura_monitoria')
  <form action="{{ route('configura.monitoria') }}" method="POST" data-parsley-validate>
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
      <div class="col-xs-4">
        <div class="form-group form-inline{{ $errors->has('semestre') ? ' has-error' : '' }}">
        <label for="">Semestre: </label>
          <input type="radio" name="semestre" id="semestre" class="radio" value="1" @if(Request::old('semestre')==1) checked @endif> 1
          <input type="radio" name="semestre" id="semestre" class="radio" value="2" @if(Request::old('semestre')==2) checked @endif> 2
        </div>
      </div>
    </div>

    <legend>Escolher disciplinas disponíveis para a Monitoria</legend>
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group form-horizontal{{ $errors->has('escolhas_coordenador') ? ' has-error' : '' }}">
        @if ($errors->has('escolhas_coordenador'))
          <span class="help-block">Você deve escolher pelo menos 01(uma) disciplina</span>
        @endif
          <input type="checkbox" name="selectAll" id="disciplinas" /> Selecionar todos
          <table class="table table-striped" id="disciplinas">
            <thead>
              <tr>
                <th>Disponível</th>
                <th>Disciplina</th>
                <th>Disponível</th>
                <th>Disciplina</th>
              </tr>
            </thead>
            <tbody>
            <?php $i=0;?>
            @while ($i < sizeof($disciplinas))
                <tr>
                  <td><input type="checkbox" id="disciplinas" name="escolhas_coordenador[]" class="checkbox" value="{{ $disciplinas[$i]->codigo }}"></td>
                  <td>{{ $disciplinas[$i]->nome }}</td>
                  @if ($i+1<sizeof($disciplinas))
                    <td><input type="checkbox" id="disciplinas" name="escolhas_coordenador[]" class="checkbox" value="{{ $disciplinas[$i+1]->codigo }}"></td>
                    <td>{{ $disciplinas[$i+1]->nome }}</td>
                  @endif
                </tr>
                <?php $i=$i+2;?>
            @endwhile
            </tbody>
          </table>
        </div>
      </div>
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
