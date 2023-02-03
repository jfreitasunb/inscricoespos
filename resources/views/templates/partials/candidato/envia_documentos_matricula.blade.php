@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('envia_documentos_matricula')

{!! Form::open(array('route' => 'envia.documentos.matricula', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '' )) !!}
  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.ficha_cadastral') }} - {{ link_to('/storage/modelo-ficha-cadastral.pdf',trans('tela_envia_documentos_matricula.modelo'), array('target' => '_blank' )) }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[1_fc]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[1_fc]" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[1_fc]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[1_fc]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.diploma_graduacao') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[2_dg]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[2_dg]" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[2_dg]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[2_dg]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.historico_graduacao') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[3_hg]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[3_hg]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[3_hg]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[3_hg]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.carteira_identidade') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[4_ci]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[4_ci]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[4_ci]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[4_ci]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.cpf') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[5_cp]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[5_cp]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[5_cp]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[5_cp]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.titulo_eleitor') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[6_te]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[6_te]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[6_te]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[6_te]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.certificado_reservista') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[7_cr]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[7_cr]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[7_cr]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[7_cr]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.carteira_identidade_estrangeiro') }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula[8_ce]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula[8_ce]"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula[8_ce]'))
            <span class="help-block">{{ $errors->first('arquivos_matricula[8_ce]') }}</span>
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
