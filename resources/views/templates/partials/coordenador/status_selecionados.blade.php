@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('status_selecionados')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Recomendantes indicados por candidato</legend>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Nome do Candidato</th>
          <th>Programa</th>
          <th>Recomendante 1</th>
          <th>Recomendante 2</th>
          <th>Recomendante 3</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dados_para_template as $dados)
          <tr class="">
            <td class="lista_carta">{{ $dados['nome_candidato'] }} <br> {{ $dados['email'] }}</td>
            <td class="lista_carta">{{ $dados['tipo_programa_pos'] }}</td>
            @if ($dados['status_carta_1'])
              <td class="lista_carta carta_completa">
            @else
              <td class="lista_carta carta_incompleta">
            @endif {{ $dados['nome_recomendante_1'] }} </br> {{ $dados['email_recomendante_1'] }}</td>
            @if ($dados['status_carta_2'])
              <td class="lista_carta carta_completa">
            @else
              <td class="lista_carta carta_incompleta">
            @endif {{ $dados['nome_recomendante_2'] }} </br> {{ $dados['email_recomendante_2'] }}</td>
            @if ($dados['status_carta_3'])
              <td class="lista_carta carta_completa">
            @else
              <td class="lista_carta carta_incompleta">
            @endif {{ $dados['nome_recomendante_3'] }} </br> {{ $dados['email_recomendante_3'] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="text-center">
    {{ $inscricoes_finalizadas->render() }}
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