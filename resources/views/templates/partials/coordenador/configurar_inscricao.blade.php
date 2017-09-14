@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
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
        <legend>Escolher os programas para Inscrição:</legend>
          @foreach($programas_pos_mat as $programa)
            <div class="col-xs-6">
              <div class="form-group form-inline">
                {!! Form::checkbox('escolhas_coordenador[]', $programa->id_programa_pos, null) !!} {{ $programa->tipo_programa_pos }}  
              </div>
            </div>
          @endforeach
        
        <legend>Edital</legend>
        <div class="col-xs-6">
          
          {!! Form::label('edital_ano', 'Ano', ['class' => 'form-group form-inline']) !!}
          {!! Form::text('edital_ano', null, ['class' => 'form-group', 'required' => '', 'data-parsley-type' => 'integer']) !!}
        </div>
        <div class="col-xs-6">
          {!! Form::label('edital_numero', 'Número', ['class' => 'form-group form-inline']) !!}
          {!! Form::text('edital_numero', null, ['class' => 'form-group', 'required' => '', 'data-parsley-type' => 'integer']) !!}
        </div>

        {!! Form::submit('Teste', array('class' => 'register-submit btn btn-primary btn-lg', 'id' => 'register-submit', 'tabindex' => '4')) !!}
      {!! Form::close() !!}
      
    </div>
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
