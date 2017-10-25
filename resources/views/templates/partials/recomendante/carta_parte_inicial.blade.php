@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('carta_parte_inicial')

{!! Form::open(array('route' => 'preencher.carta', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
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
    {!! Form::text('tempo_conhece_candidato', $dados['tempo_conhece_candidato'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
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

    <table class="table">
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
      <td>{!! Form::radio('desempenho_academico', 'Excelente', $dados['desempenho_academico']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 'Bom', $dados['desempenho_academico']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 'Regular', $dados['desempenho_academico']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 'Insuficiente', $dados['desempenho_academico']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('desempenho_academico', 'Não Sabe', $dados['desempenho_academico']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.capacidade_aprender') }}</td>
       <td>{!! Form::radio('capacidade_aprender', 'Excelente', $dados['capacidade_aprender']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 'Bom', $dados['capacidade_aprender']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 'Regular', $dados['capacidade_aprender']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 'Insuficiente', $dados['capacidade_aprender']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_aprender', 'Não Sabe', $dados['capacidade_aprender']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.capacidade_trabalhar') }}</td>
       <td>{!! Form::radio('capacidade_trabalhar', 'Excelente', $dados['capacidade_trabalhar']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 'Bom', $dados['capacidade_trabalhar']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 'Regular', $dados['capacidade_trabalhar']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 'Insuficiente', $dados['capacidade_trabalhar']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('capacidade_trabalhar', 'Não Sabe', $dados['capacidade_trabalhar']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.criatividade') }}</td>
       <td>{!! Form::radio('criatividade', 'Excelente', $dados['criatividade']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('criatividade', 'Bom', $dados['criatividade']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('criatividade', 'Regular', $dados['criatividade']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('criatividade', 'Insuficiente', $dados['criatividade']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('criatividade', 'Não Sabe', $dados['criatividade']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.curiosidade') }}</td>
       <td>{!! Form::radio('curiosidade', 'Excelente', $dados['curiosidade']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('curiosidade', 'Bom', $dados['curiosidade']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('curiosidade', 'Regular', $dados['curiosidade']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('curiosidade', 'Insuficiente', $dados['curiosidade']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('curiosidade', 'Não Sabe', $dados['curiosidade']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.esforco') }}</td>
       <td>{!! Form::radio('esforco', 'Excelente', $dados['esforco']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('esforco', 'Bom', $dados['esforco']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('esforco', 'Regular', $dados['esforco']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('esforco', 'Insuficiente', $dados['esforco']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('esforco', 'Não Sabe', $dados['esforco']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.expressao_escrita') }}</td>
       <td>{!! Form::radio('expressao_escrita', 'Excelente', $dados['expressao_escrita']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 'Bom', $dados['expressao_escrita']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 'Regular', $dados['expressao_escrita']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 'Insuficiente', $dados['expressao_escrita']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_escrita', 'Não Sabe', $dados['expressao_escrita']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.expressao_oral') }}</td>
       <td>{!! Form::radio('expressao_oral', 'Excelente', $dados['expressao_oral']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_oral', 'Bom', $dados['expressao_oral']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_oral', 'Regular', $dados['expressao_oral']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_oral', 'Insuficiente', $dados['expressao_oral']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('expressao_oral', 'Não Sabe', $dados['expressao_oral']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_inicial.relacionamento') }}</td>
       <td>{!! Form::radio('relacionamento', 'Excelente', $dados['relacionamento']!='Excelente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('relacionamento', 'Bom', $dados['relacionamento']!='Bom' ? false: true, []) !!}</td>
      <td>{!! Form::radio('relacionamento', 'Regular', $dados['relacionamento']!='Regular' ? false: true, []) !!}</td>
      <td>{!! Form::radio('relacionamento', 'Insuficiente', $dados['relacionamento']!='Insuficiente' ? false: true, []) !!}</td>
      <td>{!! Form::radio('relacionamento', 'Não Sabe', $dados['relacionamento']!='Não Sabe' ? false: true, []) !!}</td>
    </tr>
    
  </tbody>
  </table>
  
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