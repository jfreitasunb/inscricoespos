@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('cartas_anteriores')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_cartas_anteriores.cartas_antigas')}}</legend>

  <p>{{ trans('tela_cartas_anteriores.mensagem_carta_anteriores') }}</p>

  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">{{ trans('tela_cartas_pendentes.nome_candidato') }}</th>
          <th scope="col">{{ trans('tela_cartas_pendentes.tipo_programa') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $indicacoes_anteriores as $indicacoes)
          <tr>
            <td><a target="_blank" href=" {{ route('ver.anterior', ['id_inscricao_pos' => $indicacoes['id_inscricao_pos'],'id_aluno' => $indicacoes['id_candidato']]) }}">{{ $indicacoes['nome'] }}</a></td>
            <td><a target="_blank" href=" {{ route('ver.anterior', ['id_inscricao_pos' => $indicacoes['id_inscricao_pos'],'id_aluno' => $indicacoes['id_candidato']]) }}">{{ $indicacoes[$nome_coluna] }}</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
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