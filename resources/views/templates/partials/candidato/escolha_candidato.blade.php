@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('escolha_monitoria')
      <form data-parsley-validate="" action="" method="POST" class="form-group" enctype="multipart/form-data">
      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Monitorias disponíveis</legend>
        <h4 align="center">Escolha até três (03) disciplinas, em ordem de prioridade.</h4>
        <div class="form-inline">
          <div class="row">
          <p>
            <div class="form-group col-xs-6">
              <label for="email">Disciplina:</label>
              <select id="id_disciplina" name="escolha_aluno_1" class="form-control" required="">
                <option value="" selected=""></option>
                @foreach ($escolhas as $escolha)
                  <option value="{{$escolha->codigo}}" @if(Request::old('escolha_aluno_1')==$escolha->codigo) selected="" @endif >{{$escolha->nome}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-6">
              <label for="email">Menção:</label>
              <select id="id_mencao" name="mencao_aluno_1" class="form-control" required="">
                <option selected="" value=""></option>
                <option value="SS" @if(Request::old('mencao_aluno_1')=="SS") selected="" @endif>SS</option>
                <option value="MS" @if(Request::old('mencao_aluno_1')=="MS") selected="" @endif>MS</option>
                <option value="MM" @if(Request::old('mencao_aluno_1')=="MM") selected="" @endif>MM</option>
              </select>
            </div> 
            </p>
          </div>
          <div class="row">
            <p>
            <div class="form-group col-xs-6">
              <label for="email">Disciplina:</label>
              <select id="id_disciplina" name="escolha_aluno_2" class="form-control">
              <option value="" selected=""></option>
                @foreach ($escolhas as $escolha)
                  <option value="{{$escolha->codigo}}" @if(Request::old('escolha_aluno_2')==$escolha->codigo) selected="" @endif>{{$escolha->nome}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-6">
              <label for="email">Menção:</label>
              <select id="id_mencao" name="mencao_aluno_2" class="form-control">
                <option selected="" value=""></option>
                <option value="SS" @if(Request::old('mencao_aluno_2')=="SS") selected="" @endif>SS</option>
                <option value="MS" @if(Request::old('mencao_aluno_2')=="MS") selected="" @endif>MS</option>
                <option value="MM" @if(Request::old('mencao_aluno_2')=="MM") selected="" @endif>MM</option>
              </select>
            </div>
            </p>
            </div>
            <div class="row">
            <p>
            <div class="form-group col-xs-6">
              <label for="email">Disciplina:</label>
              <select id="id_disciplina" name="escolha_aluno_3" class="form-control">
              <option value="" selected=""></option>
                @foreach ($escolhas as $escolha)
                  <option value="{{$escolha->codigo}}" @if(Request::old('escolha_aluno_3')==$escolha->codigo) selected="" @endif>{{$escolha->nome}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-xs-6">
              <label for="email">Menção:</label>
              <select id="id_mencao" name="mencao_aluno_3" class="form-control">
                <option selected="" value=""></option>
                <option value="SS" @if(Request::old('mencao_aluno_3')=="SS") selected="" @endif>SS</option>
                <option value="MS" @if(Request::old('mencao_aluno_3')=="MS") selected="" @endif>MS</option>
                <option value="MM" @if(Request::old('mencao_aluno_3')=="MM") selected="" @endif>MM</option>
              </select>
            </div> 
            </p>      
          </div>
        </div>
      </fieldset>
      <fieldset class="scheduler-border">
          <legend class="scheduler-border">Você será monitor de um projeto de monitoria específico?</legend>
          <h4>Atenção: Apenas marque SIM se você foi convidado por um professor.</h4>
          <div class="form-horizontal">
              <p>
                <input type="radio" name="monitor_convidado" id="monitor_convidado" value="0" required="" @if(Request::old('monitor_convidado')=="0") checked @endif> Não<br>
                <input type="radio" name="monitor_convidado" id="monitor_convidado" value="1" @if(Request::old('monitor_convidado')=="1") checked @endif> Sim. Por favor, digite abaixo o nome do professor que será responsável por sua monitoria. Neste caso, apenas será possível matrícula na opção de monitoria voluntária.<br>
              </p>
              <h4>Caso tenha respondido "SIM" à questão anterior, escreva o nome do professor que será responsável por sua monitoria.</h4>
              <div class="col-md-6">
                <input id="nome_professor" name="nome_professor" type="text" class="form-control input-md" value="{{Request::old('nome_professor') ?: '' }}">
              </div>
            </div>
        </fieldset>

      <fieldset class="scheduler-border">
        <legend class="scheduler-border">Tipo de Monitoria</legend>
          <div class="form-horizontal">
            <div class="row">
              <p>
                <input type="radio" name="tipo_monitoria" id="somentevoluntaria" value="somentevoluntaria" required="" @if(Request::old('tipo_monitoria')=="somentevoluntaria") checked @endif> Somente voluntária<br>
                <input type="radio" name="tipo_monitoria" id="somenteremunerada" value="somenteremunerada" @if(Request::old('tipo_monitoria')=="somenteremunerada") checked @endif> Somente remunerada<br>
                <input type="radio" name="tipo_monitoria" id="indiferente" value="indiferente" @if(Request::old('tipo_monitoria')=="indiferente") checked @endif> Indiferente<br>
              </p>
          </div>
        </fieldset>
    
        <fieldset class="scheduler-border">
          <legend class="scheduler-border">Explicite seus dias e horários possíveis para a monitoria:</legend>
          <div class="form-horizontal">
            <div class="row">
              <table class="table table-striped">                     
                <div class="table responsive">
                  <thead>
                    <tr>
                    <th></th>
                    @foreach($array_horarios_disponiveis as $hora_disponivel)
                      <th class="text-center">{{$hora_disponivel}}</th>
                    @endforeach
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($array_dias_semana as $dia_semana)
                    <tr>
                      <td>{{$dia_semana}}</td>
                      <td scope="row" class="text-center">
                        <input type="checkbox" name="nome_hora_monitoria[]" value="{{$dia_semana}}_{{$array_horarios_disponiveis[0]}}" @if(is_array(Request::old('nome_hora_monitoria')) && in_array($dia_semana."_".$array_horarios_disponiveis[0],Request::old('nome_hora_monitoria'))) checked @endif>
                      </td>
                      <td class="text-center">
                        <input type="checkbox" name="nome_hora_monitoria[]" value="{{$dia_semana}}_{{$array_horarios_disponiveis[1]}}" @if(is_array(Request::old('nome_hora_monitoria')) && in_array($dia_semana."_".$array_horarios_disponiveis[1],Request::old('nome_hora_monitoria'))) checked @endif>
                      </td>
                      <td class="text-center">
                        <input type="checkbox" name="nome_hora_monitoria[]" value="{{$dia_semana}}_{{$array_horarios_disponiveis[2]}}" @if(is_array(Request::old('nome_hora_monitoria')) && in_array($dia_semana."_".$array_horarios_disponiveis[2],Request::old('nome_hora_monitoria'))) checked @endif>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </div>
              </table>
            </div>
          </div>
        </fieldset>

        <fieldset class="scheduler-border">
        <legend class="scheduler-border">Declaração de conhecimento das regras da Monitoria da UnB:</legend>
          <div class="row">
            <p>
              <input type="checkbox" name="concorda_termos" id="concorda_termos" value="1" required="" @if(Request::old('concorda_termos')=="1") checked @endif>
              Declaro conhecer os critérios de participação do Programa de Monitoria de Graduação, estabelecidos pela Resolução CEPE no 008/90 de 26.10.1990 (disponível online em <a href="http://tinyurl.com/hg3ch99" target="_blank">http://tinyurl.com/hg3ch99</a>), e ser conhecedor que a participação no Programa não estabelece nenhum vínculo empregatício meu junto a Fundação Universidade de Brasília – UnB.
            </p>
          </div>
      </fieldset>

      <div class="col-xs-12" style="height:35px;"></div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
              <input type="submit" name="registrar" id="register-submit" class="btn btn-primary btn-lg" tabindex="4" value="Enviar" {!! $disable[0] !!}>
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
