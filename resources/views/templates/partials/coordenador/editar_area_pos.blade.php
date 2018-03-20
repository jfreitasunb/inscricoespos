@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('edita_area_pos')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Áreas da Pós-Graduação</legend>

  @foreach ($areas_pos_mat as $area)
  {!! Form::open(array('route' => 'editar.area.pos', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}

  {!! Form::hidden('id_area_pos', $area->id_area_pos, []) !!}
  
    <div class="form-group">
      <div class="col-sm-1">
        {!! Form::label('nome_ptbr', 'Nome', ['class' => 'control-label']) !!}
      </div>
          <div class="col-sm-4">
            {!! Form::text('nome_ptbr', $area->nome_ptbr, ['class' => 'form-control']) !!}
          </div>
          <div class="col-sm-1">
        {!! Form::label('nome_en', 'Nome Inglês', ['class' => 'control-label']) !!}
      </div>
          <div class="col-sm-4">
            {!! Form::text('nome_en', $area->nome_en, ['class' => 'form-control']) !!}
          </div>
          <div class="col-sm-1">
        {!! Form::label('nome_es', 'Nome Espanhol', ['class' => 'control-label']) !!}
      </div>
          <div class="col-sm-4">
            {!! Form::text('nome_es', $area->nome_es, ['class' => 'form-control']) !!}
          </div>
          <div class="col-sm-2">
            {!! Form::submit('Alterar', ['class' => 'btn btn-danger pull-righ']) !!}
          </div>
      </div>
      {!! Form::close() !!}
  @endforeach
  
</fieldset>

@endsection

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection