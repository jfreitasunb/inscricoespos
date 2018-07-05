@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('homologa_inscricoes')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Fichas de Inscrição Individuais</legend>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">{{ trans('tela_cartas_pendentes.nome_candidato') }}</th>
          <th scope="col">{{ trans('tela_cartas_pendentes.tipo_programa') }}</th>
          <th>Homologar Inscrição?</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $inscricoes_finalizadas as $finalizada)
          <tr class="">
            <td>{{ $finalizada['nome'] }}</td>
            <td>{{ $finalizada['tipo_programa_pos_ptbr'] }}</td>
            <td></td>
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