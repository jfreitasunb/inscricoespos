@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('altera_status_selecionados')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Situação das confirmações</legend>
  <p>Para baixar o arquivo com as confirmações
    <a target="_blank" href="{{asset($local_arquivo_confirmacoes_template.$nome_arquivo_csv)}}" >clique aqui!</a>
  </p>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Nome do Candidato</th>
          <th>Programa</th>
          <th>Confirmou Presença?</th>
          <th>Mês de Início</th>
          <th>Selecione o mês para início</th>
          <th>Confirmar manualmente?</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($candidatos_selecionados as $dados)
          <tr class="">
            <td class="lista_carta">{{ $dados['nome'] }} <br> {{ $dados['email'] }}</td>
            <td class="lista_carta">{{ $dados['tipo_programa_pos_ptbr'] }}</td>
            @if ($dados['confirmou_presenca'])
              <td class="lista_carta carta_completa"> Sim
            @else
              <td class="lista_carta carta_incompleta"> Não
            @endif </td>
            <td>{{ $mes_candidato[$dados['id_candidato']] }}</td>
            <td>
              {!! Form::open(array('route' => 'altera.status.selecionados', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
              {!! Form::hidden('dados_candidato', $dados->id_candidato.'_'.$dados->id_inscricao_pos.'_'.$dados->id_programa_pos, []) !!}
                @foreach($meses_disponiveis as $meses)
                  <div class="col-md-4">
                    <label class="radio-inline">{!! Form::radio('mes_inicio_candidato', $meses, '', ['required' => '']) !!} {!! $meses !!}</label>
                  </div>
                @endforeach
              </td>
              <td class="col-md-4">
                {!! Form::submit('Sim', ['class' => 'btn btn-danger', 'name' => 'SIM']) !!}
                {!! Form::submit('Não', ['class' => 'btn btn-warning', 'name' => 'NAO']) !!}
              </td>
            {!! Form::close() !!}
          </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</fieldset>

@endsection

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection