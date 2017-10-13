@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('escolha_monitoria')
{!! Form::open(array('route' => 'dados.escolhas', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.programa_disponivel')}}</legend>
      
      
      <div class="row">
        @foreach($programa_para_inscricao as $programa => $key)
          <div class="col-md-4">
            <label class="radio-inline">{!! Form::radio('programa_pretendido', $programa, false, ['required' => '']) !!} {!! $key !!}</label>
          </div>
        @endforeach
        @if(isset($areas_pos))
          <div class="col-md-3">
            <label class="radio">{!! Form::select('areas_pos', $areas_pos, ['class' => 'col-md-4 control-label', 'required' => '']) !!}</label>
          </div>    
        @endif
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.interesse_bolsa')}}</legend>
      <div class="row">
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('interesse_bolsa', 0, false, ['class' => 'col-md-4 control-label', 'required' => '']) !!}Não</label>
        </div>
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('interesse_bolsa', 1, false, ['class' => 'col-md-4 control-label']) !!}Sim</label>
        </div>
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.recomendante')}}</legend>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_1', '1) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]',null , ['class' => 'control-label emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_1', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]',null , ['id' => 'email_recomendante_1', 'class' => 'control-label emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_1', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'control-label emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_1']) !!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_2', '2) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]',null , ['class' => 'control-label emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_2', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]',null , ['id' => 'email_recomendante_2', 'class' => 'control-label emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_2', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'control-label emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_2']) !!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('recomendante_3', '3) '.trans('tela_escolha_candidato.nome'), ['class' => 'control-label emailrecomendante']) !!}
          {!! Form::text('nome_recomendante[]',null , ['class' => 'control-label emailrecomendante', 'required' => '']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_3', 'E-mail: ', ['class' => 'control-label']) !!}
          {!! Form::text('email_recomendante[]',null , ['id' => 'email_recomendante_3', 'class' => 'control-label emailrecomendante', 'required' => '', 'data-parsley-type' => 'email']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('email_3', trans('tela_escolha_candidato.confirmar_email'), ['class' => 'control-label']) !!}
          {!! Form::text('confirmar_email_recomendante[]',null , ['class' => 'control-label emailrecomendante', 'required' => '', 'data-parsley-type' => 'email', 'data-parsley-equalto' => '#email_recomendante_3']) !!}
        </div>
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.motivacao')}}</legend>
      <div class="row">
        <div class="col-md-12">
          {!! Form::textarea('motivacao',null , ['required' => '']) !!} 
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
