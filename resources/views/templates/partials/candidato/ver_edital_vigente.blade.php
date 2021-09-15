@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('ver_edital_vigente')
  <div class="row">
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">{{ trans('tela_ver_edital_vigente.tela_edital_vigente') }}</legend>
      <div class="row">
        <p> {{ trans('tela_ver_edital_vigente.texto_cortesia_1') }} </p>
        <p> {{ trans('tela_ver_edital_vigente.texto_cortesia_2') }} </p>

        <p>{{ link_to($arquivos_editais.$edital_pdf.'.pdf',trans('tela_ver_edital_vigente.texto_link_edital'), array('target' => '_blank' )) }}</p>
      </div>
    </fieldset>
  </div>
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
