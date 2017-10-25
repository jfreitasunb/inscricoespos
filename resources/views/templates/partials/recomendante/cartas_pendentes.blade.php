@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('cartas_pendentes')

{!! Form::open(array('route' => 'carta.inicial', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_cartas_pendentes.tela_pendentes')}}</legend>

  <p>{{ trans('tela_cartas_pendentes.mensagem_status_cartas') }}</p>

  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{ trans('tela_cartas_pendentes.selecionar') }}</th>
      <th scope="col">{{ trans('tela_cartas_pendentes.nome_candidato') }}</th>
      <th scope="col">{{ trans('tela_cartas_pendentes.tipo_programa') }}</th>
      <th scope="col">{{ trans('tela_cartas_pendentes.situacao_carta') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach( $dados_para_template as $status)
      @if ($status['status_carta'])
        <tr class="success">
      @else
        <tr class="danger">
      @endif
      <td> {!! Form::radio('id_candidato', $status['id_candidato'], false,  $status['status_carta'] ? ['disabled'=> 'disabled'] : []) !!} </td>
      <td>{{ $status['nome_candidato'] }}</td>
      <td>{{ $status['programa_pretendido'] }}</td>
      <td>@if ($status['status_carta'])
          {{ trans('tela_cartas_pendentes.status_enviada') }}
        @else
          {{ trans('tela_cartas_pendentes.status_nao_enviada') }}
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
 
</fieldset>
<div class="form-group">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
      {!! Form::submit(trans('tela_cartas_pendentes.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
    </div>
  </div>
</div>
{!! Form::close() !!}

@endsection

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection