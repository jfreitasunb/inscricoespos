@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('cartas_anteriores')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_cartas_pendentes.tela_pendentes')}}</legend>

  <p>{{ trans('tela_cartas_pendentes.mensagem_carta_anteriores') }}</p>

  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{ trans('tela_cartas_pendentes.nome_candidato') }}</th>
      <th scope="col">{{ trans('tela_cartas_pendentes.tipo_programa') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach( $indicacoes_anteriores as $indicacoes)
      <td><a href=" {{ route('ver.anterior', ['id_inscricao_pos' => $indicacoes['id_inscricao_pos'],'id_aluno' => $indicacoes['id_aluno']]) }}">{{ $indicacoes['nome'] }}</a></td>
      <td><a href=" {{ route('ver.anterior', ['id_inscricao_pos' => $indicacoes['id_inscricao_pos'],'id_aluno' => $indicacoes['id_aluno']]) }}">{{ $indicacoes['tipo_programa_pos'] }}</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
<div class="text-center">
  {{ $indicacoes_anteriores->render() }}
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