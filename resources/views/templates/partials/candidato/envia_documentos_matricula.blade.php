@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('envia_documentos_matricula')

{!! Form::open(array('route' => 'envia.documentos.matricula', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '' )) !!}
  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.ficha_cadastral') }} - {{ link_to('ARQUIVO_MODELO.pdf',trans('tela_envia_documentos_matricula.modelo'), array('target' => '_blank' )) }}</legend>
        <div class="form-horizontal"{{ $errors->has('arquivos_matricula["fc"]') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="arquivos_matricula['fc']" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('arquivos_matricula['fc']'))
            <span class="help-block">{{ $errors->first('arquivos_matricula["fc"]') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.diploma_graduacao') }}</legend>
        <div class="form-horizontal"{{ $errors->has('diploma_graduacao') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="diploma_graduacao" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('diploma_graduacao'))
            <span class="help-block">{{ $errors->first('diploma_graduacao') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.historico_graduacao') }}</legend>
        <div class="form-horizontal"{{ $errors->has('historico_graduacao') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="historico_graduacao"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('historico_graduacao'))
            <span class="help-block">{{ $errors->first('historico_graduacao') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.carteira_identidade') }}</legend>
        <div class="form-horizontal"{{ $errors->has('carteira_identidade') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="carteira_identidade"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('carteira_identidade'))
            <span class="help-block">{{ $errors->first('carteira_identidade') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.cpf') }}</legend>
        <div class="form-horizontal"{{ $errors->has('cpf') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="cpf"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('cpf'))
            <span class="help-block">{{ $errors->first('cpf') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.titulo_eleitor') }}</legend>
        <div class="form-horizontal"{{ $errors->has('titulo_eleitor') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="titulo_eleitor"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('titulo_eleitor'))
            <span class="help-block">{{ $errors->first('titulo_eleitor') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.carteira_identidade_estrangeiro') }}</legend>
        <div class="form-horizontal"{{ $errors->has('carteira_identidade_estrangeiro') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="carteira_identidade_estrangeiro"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('carteira_identidade_estrangeiro'))
            <span class="help-block">{{ $errors->first('carteira_identidade_estrangeiro') }}</span>
          @endif
        </div>
  </fieldset>
  
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
