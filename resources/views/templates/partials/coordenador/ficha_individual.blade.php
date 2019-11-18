@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('ficha_individual')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Fichas de Inscrição Individuais</legend>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">{{ trans('tela_cartas_pendentes.nome_candidato') }}</th>
          <th scope="col">{{ trans('tela_cartas_pendentes.tipo_programa') }}</th>
          <th>Ficha de Inscrição</th>
          <th>Cartas Recebidas</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $inscricoes_finalizadas as $finalizada)
          <tr class="{{ $classes_linhas[$total_cartas[$finalizada['id_candidato']]] }}">
            <td><a href=" {{ route('ver.ficha.individual', ['id_inscricao_pos' => $finalizada['id_inscricao_pos'],'id_aluno' => $finalizada['id_candidato']]) }}">{{ $finalizada['nome'] }}</a></td>
            <td><a href=" {{ route('ver.ficha.individual', ['id_inscricao_pos' => $finalizada['id_inscricao_pos'],'id_aluno' => $finalizada['id_candidato']]) }}">{{ $finalizada['tipo_programa_pos_ptbr'] }}</a></td>
            <td>@if($id_aluno_pdf == $finalizada['id_candidato']) <a target="_blank" href="{{asset($nome_pdf)}}" > Ficha de Inscrição </a> @endif</td>
            <td>{{ $total_cartas[$finalizada['id_candidato']] }}</td>
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