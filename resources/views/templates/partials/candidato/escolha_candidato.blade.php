@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('escolha_monitoria')
<fieldset class="scheduler-border">
  <legend class="scheduler-border"></legend>
    <div class="row">
      {{trans('tela_escolha_candidato.texto_programa')}}
    </div>
</fieldset>

{!! Form::open(array('route' => 'dados.escolhas', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.programa_disponivel')}}</legend>
      <div class="row">
        @foreach($programa_para_inscricao as $programa => $key)
          <div class="col-md-4">
            <label class="radio-inline">{!! Form::radio('programa_pretendido', $programa, $dados['programa_pretendido'] == $programa ?: '', ['required' => '']) !!} {!! $key !!}</label>
          </div>
        @endforeach
        @if(isset($areas_pos))
          <div class="col-md-3">
            <label class="radio">{!! Form::select('area_pos', $areas_pos, $dados['area_pos'] ? : '',  ['class' => 'form-control col-md-6']) !!}</label>
          </div>    
        @endif
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
  <legend class="scheduler-border"></legend>
    <div class="row">
      {{trans('tela_escolha_candidato.texto_bolsas')}}
    </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{ trans('tela_escolha_candidato.interesse_bolsa') }}</legend>
      <div class="row">
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('interesse_bolsa', 0, !$dados['interesse_bolsa'] ? true : false, ['class' => 'col-md-4 control-label', 'required' => '']) !!}{{ trans('tela_escolha_candidato.nao') }}</label>
        </div>
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('interesse_bolsa', 1, $dados['interesse_bolsa'] ? true : false, ['class' => 'col-md-4 control-label']) !!}{{ trans('tela_escolha_candidato.sim') }}</label>
        </div>
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.vinculo_empregaticio')}}</legend>
      <div class="row">
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('vinculo_empregaticio', 0, !$dados['vinculo_empregaticio'] ? true : false, ['class' => 'col-md-4 control-label', 'required' => '']) !!}{{ trans('tela_escolha_candidato.nao') }}</label>
        </div>
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('vinculo_empregaticio', 1, $dados['vinculo_empregaticio'] ? true : false, ['class' => 'col-md-4 control-label']) !!}{{ trans('tela_escolha_candidato.sim') }}</label>
        </div>
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
  <legend class="scheduler-border"></legend>
    <div class="row">
      {{trans('tela_escolha_candidato.texto_recomendantes')}}
    </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.recomendante')}}</legend>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_1', '1) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]', $dados['nome_recomendante_1'] ?: '' , ['class' => 'emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_1', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]', $dados['email_recomendante_1'] ?: '' , ['id' => 'email_recomendante_1', 'class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_1', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_1']) !!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_2', '2) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]', $dados['nome_recomendante_2'] ?: '' , ['class' => 'emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_2', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]',$dados['email_recomendante_2'] ?: '' , ['id' => 'email_recomendante_2', 'class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_2', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_2']) !!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_3', '3) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]', $dados['nome_recomendante_3'] ?: '' , ['class' => 'emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_3', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]',$dados['email_recomendante_3'] ?: '' , ['id' => 'email_recomendante_3', 'class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_3', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_3']) !!}
        </div>
      </div>
  </fieldset>
  
      <div class="form-group">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            {!! Form::submit(trans('tela_escolha_candidato.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  
@endsection

@section('scripts')
  {!! Html::script( asset('js/parsley.min.js') ) !!}
  {!! Html::script( asset('i18n/pt-br.js') ) !!}
@endsection
