@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('ficha_individual')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_cartas_pendentes.tela_pendentes')}}</legend>

  <p>{{ trans('tela_cartas_pendentes.mensagem_carta_anteriores') }}</p>

  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{ trans('tela_cartas_pendentes.nome_candidato') }}</th>
      <th scope="col">{{ trans('tela_cartas_pendentes.tipo_programa') }}</th>
      <th>Ficha de Inscrição</th>
    </tr>
  </thead>
  <tbody>
    @foreach( $inscricoes_finalizadas as $finalizada)
      <td><a href=" {{ route('ver.ficha.individual', ['id_inscricao_pos' => $finalizada['id_inscricao_pos'],'id_aluno' => $finalizada['id_user']]) }}">{{ $finalizada['nome'] }}</a></td>
      <td><a href=" {{ route('ver.ficha.individual', ['id_inscricao_pos' => $finalizada['id_inscricao_pos'],'id_aluno' => $finalizada['id_user']]) }}">{{ $finalizada['tipo_programa_pos'] }}</a></td>
      <td>@if($id_aluno_pdf == $finalizada['id_user']) <a target="_blank" href="{{asset($nome_pdf)}}" > Ficha de Inscrição </a> @endif</td>
    </tr>
    @endforeach
  </tbody>
</table>
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