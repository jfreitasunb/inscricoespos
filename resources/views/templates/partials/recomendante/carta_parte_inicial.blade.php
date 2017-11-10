@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('carta_parte_inicial')

{!! Form::open(array('route' => 'salva.carta.inicial', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_carta_parte_inicial.tela_pendentes')}}</legend>

  <div class="row">
    {!! Form::label('nome_candidato', trans('tela_carta_parte_inicial.nome_candidato'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::text('nome_candidato', $dados_candidato['nome_candidato'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'disabled']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('programa_pretendido', trans('tela_carta_parte_inicial.programa_pretendido_candidato'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::text('programa_pretendido', $dados_candidato['programa_pretendido'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'disabled']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('tempo_conhece_candidato', trans('tela_carta_parte_inicial.tempo_conhece_candidato'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::text('tempo_conhece_candidato', $dados['tempo_conhece_candidato'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '', 'data-parsley-minlength' => '5']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('circunstancia', trans('tela_carta_parte_inicial.circunstancia'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::checkbox('circunstancia_1', 'Aula', $dados['circunstancia_1'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_1') }}
    {!! Form::checkbox('circunstancia_2', 'Orientação', $dados['circunstancia_2'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_2') }}
    {!! Form::checkbox('circunstancia_3', 'Seminários', $dados['circunstancia_3'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_3') }}
    {!! Form::checkbox('circunstancia_4', 'Outra', $dados['circunstancia_4'] ?: null ) !!} {{ trans('tela_carta_parte_inicial.circunstancia_4') }}
    {!! Form::text('circunstancia_outra',  $dados['circunstancia_outra'] ?: '', [ 'class' => 'form-control form-inline'] ) !!}
    </div>
  </div>

  <strong><p>{{ trans('tela_carta_parte_inicial.tabela_avaliacao') }}</p></strong>

    <table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">{{ trans('tela_carta_parte_inicial.excelente') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_inicial.bom') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_inicial.regular') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_inicial.insuficiente') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_inicial.nao_sabe') }}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.desempenho_academico') }}</td>
      <td>{!! Form::radio('desempenho_academico', 1, $dados['desempenho_academico'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 2, $dados['desempenho_academico'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 3, $dados['desempenho_academico'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 4, $dados['desempenho_academico'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 5, $dados['desempenho_academico'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.capacidade_aprender') }}</td>
       <td>{!! Form::radio('capacidade_aprender', 1, $dados['capacidade_aprender'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 2, $dados['capacidade_aprender'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 3, $dados['capacidade_aprender'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 4, $dados['capacidade_aprender'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 5, $dados['capacidade_aprender'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.capacidade_trabalhar') }}</td>
       <td>{!! Form::radio('capacidade_trabalhar', 1, $dados['capacidade_trabalhar'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 2, $dados['capacidade_trabalhar'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 3, $dados['capacidade_trabalhar'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 4, $dados['capacidade_trabalhar'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 5, $dados['capacidade_trabalhar'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.criatividade') }}</td>
       <td>{!! Form::radio('criatividade', 1, $dados['criatividade'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('criatividade', 2, $dados['criatividade'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('criatividade', 3, $dados['criatividade'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('criatividade', 4, $dados['criatividade'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('criatividade', 5, $dados['criatividade'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.curiosidade') }}</td>
       <td>{!! Form::radio('curiosidade', 1, $dados['curiosidade'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('curiosidade', 2, $dados['curiosidade'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('curiosidade', 3, $dados['curiosidade'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('curiosidade', 4, $dados['curiosidade'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('curiosidade', 5, $dados['curiosidade'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.esforco') }}</td>
       <td>{!! Form::radio('esforco', 1, $dados['esforco'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('esforco', 2, $dados['esforco'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('esforco', 3, $dados['esforco'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('esforco', 4, $dados['esforco'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('esforco', 5, $dados['esforco'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.expressao_escrita') }}</td>
       <td>{!! Form::radio('expressao_escrita', 1, $dados['expressao_escrita'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 2, $dados['expressao_escrita'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 3, $dados['expressao_escrita'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 4, $dados['expressao_escrita'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 5, $dados['expressao_escrita'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.expressao_oral') }}</td>
       <td>{!! Form::radio('expressao_oral', 1, $dados['expressao_oral'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('expressao_oral', 2, $dados['expressao_oral'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_oral', 3, $dados['expressao_oral'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_oral', 4, $dados['expressao_oral'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_oral', 5, $dados['expressao_oral'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.relacionamento') }}</td>
       <td>{!! Form::radio('relacionamento', 1, $dados['relacionamento'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('relacionamento', 2, $dados['relacionamento'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('relacionamento', 3, $dados['relacionamento'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('relacionamento', 4, $dados['relacionamento'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('relacionamento', 5, $dados['relacionamento'] != '5' ? false: true, []) !!}</td>
    </tr>
  </tbody>
  </table>

   <div id="checkbox-errors"></div>
  
  {!! Form::hidden('id_candidato', $id_candidato, []) !!}

 
</fieldset>
<div class="form-group">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
      {!! Form::submit(trans('tela_carta_parte_inicial.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
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