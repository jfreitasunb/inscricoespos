@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('carta_parte_final')

{!! Form::open(array('route' => 'finalizar.carta', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
<fieldset class="scheduler-border">
  <legend class="scheduler-border">{{trans('tela_carta_parte_final.tela_pendentes')}}</legend>

  <div class="row">
    {!! Form::label('antecedentes_academicos', trans('tela_carta_parte_final.opiniao_antecedentes_academicos'), ['class' => 'col-md-4 control-label', 'required' => ''])!!}
    <div class="col-md-4">
    {!! Form::textarea('antecedentes_academicos', $dados['antecedentes_academicos'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'rows' => '5', 'required' => '']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('possivel_aproveitamento', trans('tela_carta_parte_final.opiniao_desempenho_candidato'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::textarea('possivel_aproveitamento', $dados['possivel_aproveitamento'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'rows' => '5', 'required' => '']) !!}
    </div>
  </div>

  <div class="row">
    {!! Form::label('informacoes_relevantes', trans('tela_carta_parte_final.outras_informacoes_relevantes'), ['class' => 'col-md-4 control-label'])!!}
    <div class="col-md-4">
    {!! Form::textarea('informacoes_relevantes', $dados['informacoes_relevantes'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'rows' => '5', 'required' => '']) !!}
    </div>
  </div>

  <strong><p>{{ trans('tela_carta_parte_final.classifica_candidato') }}</p></strong>

    <table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">{{ trans('tela_carta_parte_final.top_5') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_final.top_10') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_final.top_25') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_final.top_50') }}</th>
      <th scope="col">{{ trans('tela_carta_parte_final.nao_sabe') }}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ trans('tela_carta_parte_final.como_aluno') }}</td>
      <td>{!! Form::radio('como_aluno', 1, $dados['como_aluno'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('como_aluno', 2, $dados['como_aluno'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('como_aluno', 3, $dados['como_aluno'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('como_aluno', 4, $dados['como_aluno'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('como_aluno', 5, $dados['como_aluno'] != '5' ? false: true, []) !!}</td>
    </tr>
    <tr>
      <td>{{ trans('tela_carta_parte_final.como_orientando') }}</td>
       <td>{!! Form::radio('como_orientando', 1, $dados['como_orientando'] != '1' ? false: true, ['data-parsley-errors-container' => '#checkbox-errors', 'required' => '']) !!}</td>
      <td>{!! Form::radio('como_orientando', 2, $dados['como_orientando'] != '2' ? false: true, []) !!}</td>
      <td>{!! Form::radio('como_orientando', 3, $dados['como_orientando'] != '3' ? false: true, []) !!}</td>
      <td>{!! Form::radio('como_orientando', 4, $dados['como_orientando'] != '4' ? false: true, []) !!}</td>
      <td>{!! Form::radio('como_orientando', 5, $dados['como_orientando'] != '5' ? false: true, []) !!}</td>
    </tr>    
  </tbody>
  </table>
 
 <div id="checkbox-errors"></div>

 {!! Form::hidden('id_candidato', $id_candidato, []) !!}
</fieldset>
<div class="form-group">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
      {!! Form::submit(trans('tela_carta_parte_final.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
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