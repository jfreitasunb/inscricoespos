@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
@endsection

@section('escolha_monitoria')
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.programa_disponivel')}}</legend>
      {!! Form::open(array('route' => 'dados.escolhas', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
      
      <div class="row">
        @foreach($programa_para_inscricao as $programa => $key)
          <div class="col-md-4">
            <label class="radio-inline">{!! Form::radio('programa_pretendido', $programa, false , ['class' => 'col-md-4 control-label']) !!} {!! $key !!}</label>
          </div>
        @endforeach
        @if(isset($areas_pos))
          <div class="col-md-3">
            <label class="radio">{!! Form::select('areas_pos', $areas_pos, ['class' => 'col-md-4 control-label']) !!}</label>
          </div>    
        @endif
      </div>
  </fieldset>

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_escolha_candidato.interesse_bolsa')}}</legend>
      <div class="row">
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('interesse_bolsa', 0, false, ['class' => 'col-md-4 control-label']) !!}Não</label>
        </div>
        <div class="col-md-4">
          <label class="radio-inline">{!! Form::radio('interesse_bolsa', 1, false, ['class' => 'col-md-4 control-label']) !!}Sim</label>
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
