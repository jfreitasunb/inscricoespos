@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('processa_documentos_matricula')
{!! Form::open(array('route' => 'documento.final.matricula', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
      
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_finalizar_documentos_matricula.tela_finaliza')}}</legend>
      <div class="row">
        {{ trans('tela_finalizar_documentos_matricula.texto_finaliza') }}
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_finalizar_documentos_matricula.ficha_inscricao')}}</legend>
      <div class="row">
        <a href="{{ asset($dados_para_template['ficha_inscricao']) }}" target="_blank"><i class="fa fa-file-pdf-o fa-4x"></i>{{ $dados_para_template['nome_candidato'] }}</a>
          {{-- {{ link_to($ficha_inscricao,''.$nome_candidato, array('target' => '_blank' ) ) }} --}}
      </div>
  </fieldset>
  {!! Form::hidden('id_candidato', $dados_para_template['id_candidato'], []) !!}
  {!! Form::hidden('id_inscricao_pos', $dados_para_template['id_inscricao_pos'], []) !!}
  {!! Form::hidden('id_programa_pretendido', $dados_para_template['id_programa_pretendido'], []) !!}
  {!! Form::hidden('ficha_inscricao', $dados_para_template['ficha_inscricao'], []) !!}
      <div class="form-group">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            {!! Form::submit(trans('tela_finalizar_documentos_matricula.menu_envio_definitivo'), ['class' => 'btn btn-danger btn-lg register-submit']) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
