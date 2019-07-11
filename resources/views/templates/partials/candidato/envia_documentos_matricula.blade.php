@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('envia_documentos_matricula')

{!! Form::open(array('route' => 'envia.documentos.matricula', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '' )) !!}
  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.ficha_cadastral') }} - {{ link_to('ARQUIVO_MODELO.pdf',trans('tela_envia_documentos_matricula.modelo'), array('target' => '_blank' )) }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[fc]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[fc]" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[fc]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[fc]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.diploma_graduacao') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[dg]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[dg]" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[dg]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[dg]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.historico_graduacao') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[hg]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[hg]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[hg]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[hg]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.carteira_identidade') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[ci]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[ci]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[ci]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[ci]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.cpf') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[cpf]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[cpf]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[cpf]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[cpf]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.titulo_eleitor') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[te]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[te]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[te]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[te]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.carteira_identidade_estrangeiro') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[ce]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[ce]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[ce]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[ce]') }}</span>
          @endif
        </div>
  </fieldset>
  {!! Form::hidden('id_inscricao_pos', $dados_para_template['id_inscricao_pos'], []) !!}
  {!! Form::hidden('id_candidato', $dados_para_template['id_candidato'], []) !!}
  {!! Form::hidden('id_programa_pretendido', $dados_para_template['id_programa_pretendido'], []) !!}
  <div class="form-group">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 text-center">
        {!! Form::submit(trans('tela_envia_documentos_matricula.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
      </div>
    </div>
  </div>
  {!! Form::close() !!}
  
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
