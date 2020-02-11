@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('configura_inscricao')
  
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      {!! Form::open(array('route' => 'configura.inscricao','data-parsley-validate' => '' ,'enctype' => 'multipart/form-data')) !!}
        <legend>Configurar período da abertura da inscrição</legend>
        <div class="col-xs-4">
          <div class="form-group form-inline">
            {!! Form::label('inicio_inscricao', 'Início da Inscrição:') !!}
            <div class='input-group' id='inicio_inscricao'>
              {!! Form::text('inicio_inscricao', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group form-inline">
            {!! Form::label('fim_inscricao', 'Final da Inscrição:') !!}
            <div class='input-group' id='fim_inscricao'>
              {!! Form::text('fim_inscricao', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group form-inline">
            {!! Form::label('prazo_carta', 'Prazo para envio da carta:') !!}
            <div class='input-group' id='prazo_carta'>
              {!! Form::text('prazo_carta', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4 col-md-offset-1">
          <div class="form-group form-inline">
            {!! Form::label('data_homologacao', 'Data da Homologação das Inscrições:') !!}
            <div class='input-group' id='data_homologacao'>
              {!! Form::text('data_homologacao', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-xs-4 col-md-offset-1">
          <div class="form-group form-inline">
            {!! Form::label('data_divulgacao_resultado', 'Data da divulgação do resultado:') !!}
            <div class='input-group' id='data_divulgacao_resultado'>
              {!! Form::text('data_divulgacao_resultado', null, ['class' => 'form-control', 'required' => '']) !!}
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        </div>
        <legend>Escolher os programas para Inscrição:</legend>
          @foreach($programas_pos_mat as $programa)
            <div class="col-xs-6">
              <div class="form-group form-inline">
                <label>
                  {!! Form::checkbox('escolhas_coordenador[]', $programa->id_programa_pos, null) !!} {{ $programa->tipo_programa_pos_ptbr }} 
                </label> 
              </div>
            </div>
          @endforeach
  
        <legend>É necessário indicar recomendantes?</legend>
        <div class="row">
          <div class="col-md-4">
            <label class="radio-inline">{!! Form::radio('necessita_recomendante', 1, true, ['class' => 'col-md-4 control-label', 'required' => '']) !!}Sim</label>
          </div>
          <div class="col-md-4">
            <label class="radio-inline">{!! Form::radio('necessita_recomendante', 0, false, ['class' => 'col-md-4 control-label']) !!}Não</label>
          </div>
        </div>
        <div class="row">&nbsp;</div>

        <legend>Edital</legend>
        <div class="col-xs-6">
          
          {!! Form::label('edital_ano', 'Ano', ['class' => 'form-group form-inline']) !!}
          {!! Form::text('edital_ano', null, ['class' => 'form-group', 'required' => '']) !!}
        </div>
        <div class="col-xs-6">
          {!! Form::label('edital_numero', 'Número', ['class' => 'form-group form-inline']) !!}
          {!! Form::text('edital_numero', null, ['class' => 'form-group', 'required' => '', 'data-parsley-type' => 'integer']) !!}
        </div>

        <legend>Arquivo com Edital em Português</legend>
        <span class="input-group-btn">
          <button type="button" class="btn btn-primary" style="display:none;">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
          <div class="register-submit btn btn-primary">
            <input type="file" accept="application/pdf" name="edital_portugues" required=""/>
          </div>
        </span>
        @if ($errors->has('edital_portugues'))
          <span class="help-block">{{ $errors->first('edital_portugues') }}</span>
        @endif
        <legend></legend>
        <legend>Arquivo com Edital em Inglês</legend>
        <span class="input-group-btn">
          <button type="button" class="btn btn-primary" style="display:none;">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
          <div class="register-submit btn btn-primary">
            <input type="file" accept="application/pdf" name="edital_ingles"/>
          </div>
        </span>
        @if ($errors->has('edital_ingles'))
          <span class="help-block">{{ $errors->first('edital_ingles') }}</span>
        @endif
        <legend></legend>
        <legend>Arquivo com Edital em Espanhol</legend>
        <span class="input-group-btn">
          <button type="button" class="btn btn-primary" style="display:none;">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
          <div class="register-submit btn btn-primary">
            <input type="file" accept="application/pdf" name="edital_espanhol"/>
          </div>
        </span>
        @if ($errors->has('edital_espanhol'))
          <span class="help-block">{{ $errors->first('edital_espanhol') }}</span>
        @endif
        <legend></legend>
        <div class="col-md-10 text-center"> 
          {!! Form::submit('Salvar', array('class' => 'register-submit btn btn-primary btn-lg', 'id' => 'register-submit', 'tabindex' => '4')) !!}
        </div>
    </div>
      {!! Form::close() !!}
      
  </div>

@endsection

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection
