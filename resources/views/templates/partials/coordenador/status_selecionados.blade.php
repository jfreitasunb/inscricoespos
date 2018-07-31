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
          <th>Confirmou Presença?</th>
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
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="text-center">
    {{ $candidatos_selecionados->render() }}
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