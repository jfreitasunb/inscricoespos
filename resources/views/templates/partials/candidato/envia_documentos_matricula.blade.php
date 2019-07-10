@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('envia_documentos_matricula')
<fieldset class="scheduler-border">
  <legend class="scheduler-border"></legend>
    <div class="row">
      {{trans('tela_envia_documentos_matricula.texto_motivacao')}}
    </div>
</fieldset>

{!! Form::open(array('route' => 'motivacao.documentos', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '' )) !!}
      
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_envia_documentos_matricula.motivacao')}}</legend>
      <div class="row">
        <div class="col-md-12">
          {!! Form::textarea('motivacao', $dados['motivacao'] ?: '' , ['class' => 'form-control', 'rows' => '15', 'required' => '']) !!} 
        </div>
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.documentos_pessoais') }}</legend>
        <div class="form-horizontal"{{ $errors->has('documentos_pessoais') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="documentos_pessoais" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('documentos_pessoais'))
            <span class="help-block">{{ $errors->first('documentos_pessoais') }}</span>
          @endif
        </div>
  </fieldset>

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.historico') }}</legend>
        <div class="form-horizontal"{{ $errors->has('historico') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="historico" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('historico'))
            <span class="help-block">{{ $errors->first('historico') }}</span>
          @endif
        </div>
  </fieldset>

  {{-- <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.comprovante_ingles') }}</legend>
        <div class="form-horizontal"{{ $errors->has('comprovante_ingles') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="comprovante_ingles" required=""/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('comprovante_ingles'))
            <span class="help-block">{{ $errors->first('comprovante_ingles') }}</span>
          @endif
        </div>
  </fieldset> --}}

  <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ trans('tela_envia_documentos_matricula.comprovante_proficiencia') }}</legend>
        <div class="form-horizontal"{{ $errors->has('comprovante_proficiencia') ? ' has-error' : '' }}>
          <div class="row">
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-primary" style="display:none;">
                    <span class="glyphicon glyphicon-remove"></span> Clear
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-primary">
                    <input type="file" accept="application/pdf" name="comprovante_proficiencia"/> <!-- rename it -->
                </div>
            </span>
          </div>
           @if ($errors->has('comprovante_proficiencia'))
            <span class="help-block">{{ $errors->first('comprovante_proficiencia') }}</span>
          @endif
        </div>
  </fieldset>
  
  <fieldset class="scheduler-border">
      <div class="row">
        <p> {{ trans('tela_envia_documentos_matricula.concordancia_1') }} {{ link_to($arquivos_editais.$edital_pdf.'.pdf',trans('tela_envia_documentos_matricula.texto_link_edital'), array('target' => '_blank' )) }} {{ trans('tela_envia_documentos_matricula.concordancia_2') }}</p>
        <label>
          {!! Form::checkbox('concorda_termos', '1', null, ['class' => 'control-label', 'required' => '']) !!} {{ trans('tela_envia_documentos_matricula.concordancia_3') }}
        </label>
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
