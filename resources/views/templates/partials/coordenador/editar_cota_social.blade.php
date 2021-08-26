@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('edita_cota_social')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Tipo de Cota</legend>

  
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Nome Português</th>
          <th>Nome Inglês</th>
          <th>Nome Espanhol</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($cota_social as $cotista)
          <tr>
            {!! Form::open(array('route' => 'editar.cota.social', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
            {!! Form::hidden('id_cota_social', $cotista->id, []) !!}
            <td>{!! Form::text('cota_social_ptbr', $cotista->cota_social_ptbr, ['class' => 'form-control']) !!}</td>
            <td>{!! Form::text('cota_social_en', $cotista->cota_social_en, ['class' => 'form-control']) !!}</td>
            <td>{!! Form::text('cota_social_es', $cotista->cota_social_es, ['class' => 'form-control']) !!}</td>
            <td>{!! Form::submit('Alterar', ['class' => 'btn btn-danger pull-righ']) !!}</td>
            {!! Form::close() !!}
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  
  
  
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