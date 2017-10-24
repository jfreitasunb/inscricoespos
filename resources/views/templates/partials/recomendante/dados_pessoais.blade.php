@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('dados_pessoais_recomendante')
<div class="row">
  {!! Form::open(array('route' => 'dados.recomendante', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">Dados Pessoais</legend>
        
        <div class="row">
          {!! Form::label('nome_recomendante', trans('tela_recomendante_dados_pessoais.nome_recomendante'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('nome_recomendante', $dados['nome_recomendante'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('instituicao_recomendante', trans('tela_recomendante_dados_pessoais.instituicao_recomendante'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('instituicao_recomendante', $dados['instituicao_recomendante'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('titulacao_recomendante', trans('tela_recomendante_dados_pessoais.titulacao_recomendante'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('titulacao_recomendante', $dados['titulacao_recomendante'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>
        
        <div class="row">
          {!! Form::label('area_recomendante', trans('tela_recomendante_dados_pessoais.area_recomendante'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('area_recomendante', $dados['area_recomendante'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('ano_titulacao', trans('tela_recomendante_dados_pessoais.ano_titulacao'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('ano_titulacao', $dados['ano_titulacao'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>
        
        <div class="row">
          {!! Form::label('inst_obtencao_titulo', trans('tela_recomendante_dados_pessoais.inst_obtencao_titulo'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::textarea('inst_obtencao_titulo', $dados['inst_obtencao_titulo'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'rows' =>'2', 'required' => '']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('endereco_recomendante', trans('tela_recomendante_dados_pessoais.endereco_recomendante'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::textarea('endereco_recomendante', $dados['endereco_recomendante'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'rows' => '5', 'required' => '']) !!}
          </div>
        </div>
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
              {!! Form::submit(trans('tela_recomendante_dados_pessoais.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
            </div>
          </div>
        </div>

      {!! Form::close() !!}
    </fieldset>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('js/parsley.min.js') }}"></script>
  <script src="{{ asset('i18n/pt-br.js') }}"></script>
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection