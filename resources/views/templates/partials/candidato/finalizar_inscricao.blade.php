@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('finaliza_inscricao')
{!! Form::open(array('route' => 'finalizar.inscricao', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
      
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_finalizar_inscricao.tela_finaliza')}}</legend>
      <div class="row">
        {{ trans('tela_finalizar_inscricao.texto_finaliza') }}
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_finalizar_inscricao.ficha_inscricao')}}</legend>
      <div class="row">
        <a href="{{ asset($ficha_inscricao) }}" target="_blank"><i class="fa fa-file-pdf-o fa-4x"></i>{{ $nome_candidato }}</a>
          {{-- {{ link_to($ficha_inscricao,''.$nome_candidato, array('target' => '_blank' ) ) }} --}}
      </div>
  </fieldset>
  {!! Form::hidden('ficha_inscricao', $ficha_inscricao, []) !!}
      <div class="form-group">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            {!! Form::submit(trans('tela_finalizar_inscricao.menu_envio_definitivo'), ['class' => 'btn btn-danger btn-lg register-submit']) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
