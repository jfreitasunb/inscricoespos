@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('dados_academicos')
{!! Form::open(array('route' => 'dados.academicos', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}

<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_dados_academicos.curso_graduacao')}}</legend>
  <div class="row">
    {!! Form::label('curso_graduacao', trans('tela_dados_academicos.curso'), ['class' => 'col-md-4 control-label'])!!}
      <div class="col-md-4">
        {!! Form::text('curso_graduacao', $dados['curso_graduacao'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('tipo_curso_graduacao', trans('tela_dados_academicos.tipo_curso'), ['class' => 'col-md-4 control-label'])!!}
      <div class="col-md-4">
        {!! Form::select('tipo_curso_graduacao', $graduacao, $dados['tipo_curso_graduacao'] ?: '', ['class' => 'form-control formhorizontal']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('instituicao_graduacao', trans('tela_dados_academicos.instituicao'), ['class' => 'col-md-4 control-label'])!!}
      <div class="col-md-4">
        {!! Form::text('instituicao_graduacao', $dados['instituicao_graduacao'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('ano_conclusao_graduacao', trans('tela_dados_academicos.ano_conclusao'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
      {!! Form::text('ano_conclusao_graduacao', $dados['ano_conclusao_graduacao'] ?: '', ['class' => 'form-control input-md formhorizontal']) !!}
    </div>
  </div>
</fieldset>

<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_dados_academicos.curso_pos')}}</legend>
  <div class="row">
    {!! Form::label('curso_pos', trans('tela_dados_academicos.curso'), ['class' => 'col-md-4 control-label'])!!}
      <div class="col-md-4">
        {!! Form::text('curso_pos', $dados['curso_pos'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
    </div>
  </div>

  {{-- <div class="row">
    {!! Form::label('nivel_pos', trans('tela_dados_academicos.nivel'), ['class' => 'col-md-4 control-label'])!!}
      <div class="col-md-4">
        @foreach ($nivel_candidato as $nivel => $key)
          <label class="radio-inline">{{ Form::radio('nivel_pos', $nivel, $dados['nivel_pos'] ? true : false, ['id'=>'nivel_pos']) }} {!! $key !!}</label>
        @endforeach
    </div>
  </div> --}}

  <div class="row">
    {!! Form::label('tipo_curso_pos', trans('tela_dados_academicos.tipo_curso'), ['class' => 'col-md-4 control-label'])!!}
      <div class="col-md-4">
        {!! Form::select('tipo_curso_pos', $pos, $dados['tipo_curso_pos'] ?: '', ['class' => ' form-control formhorizontal']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('instituicao_pos', trans('tela_dados_academicos.instituicao'), ['class' => 'col-md-4 control-label'])!!}
      <div class="col-md-4">
        {!! Form::text('instituicao_pos', $dados['instituicao_pos'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('ano_conclusao_pos', trans('tela_dados_academicos.ano_conclusao'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
      {!! Form::text('ano_conclusao_pos', $dados['ano_conclusao_pos'] ?: '', ['class' => 'form-control input-md formhorizontal']) !!}
    </div>
  </div>
</fieldset>

<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_dados_academicos.disciplinas_destaque')}}</legend>
  @if (count($disciplinas_destaque) > 0)
    <div class="row">
      {{trans('tela_dados_academicos.texto_disciplinas_destaque')}}
    </div>
    <table class="table table-bordered">
      <tr>
        <th>{{ trans('tela_dados_academicos.nome_disciplina') }}</th>

        <th>{{ trans('tela_dados_academicos.mencao') }}</th>

        <th>{{ trans('tela_dados_academicos.remove_destaque') }}</th>
      </tr>
      @foreach ($disciplinas_destaque as $disciplina)
        <tr>
          <td>{{ $disciplina['nome_disciplina'] }}</td>
          <td>{{ $disciplina['mencao'] }}</td>
          <td>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="remover_destaque[{{ $disciplina['id'] }}][]" id="inlineRadio1" value="0" checked>
              <label class="form-check-label" for="inlineRadio1">Não</label>
              <input class="form-check-input" type="radio" name="remover_destaque[{{ $disciplina['id'] }}][]" id="inlineRadio2" value="1">
              <label class="form-check-label" for="inlineRadio2">Sim</label>
            </div>
          </td>
        </tr>
      @endforeach
    </table>
  @endif
  <div class="row">
    <table class="table table-bordered" id="dynamicTable">
      <tr>
        <th>{{ trans('tela_dados_academicos.nome_disciplina') }}</th>

        <th>{{ trans('tela_dados_academicos.mencao') }}</th>

        <th>{{ trans('tela_dados_academicos.acao') }}</th>
      </tr>

      <tr>
        <td><input type="text" name="discplinas_destaque[0][nome_disciplina]" placeholder="{{ trans('tela_dados_academicos.placeholder_nome_disciplina') }}" class="form-control" /></td>

        <td><select name="discplinas_destaque[0][mencao]" class="form-control" /><option value="" selected="selected">Selecione</option><option value="SS">SS</option><option value="MS">MS</option><option value="MM">MM</option></select></td>

        <td><button type="button" name="add" id="add" class="btn btn-success">{{ trans('tela_dados_academicos.adicionar_mais') }}</button></td>
      </tr>
    </table>
  </div>
</fieldset>

<div class="form-group">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
      {!! Form::submit(trans('tela_dados_academicos.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
    </div>
  </div>
</div>
{!! Form::close() !!}
@endsection

@section('scripts')
  {!! Html::script( asset('//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/addmore.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection