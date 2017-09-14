@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('configura_inscricao')
  
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <legend>Configurar período da abertura da inscrição</legend>
      {!! Form::open(array('route' => 'configura.inscricao','data-parsley-validate' => '','enctype' => 'multipart/form-data')) !!}
        {{ Form::label('dateA','Date Aquired')}}
      {{ Form::text('startingDate', null, array('class' => 'form-control input-sm','placeholder' => 'Starting Date','data-provide' => 'datepicker')) }}
        {!! Form::submit('Teste', array('class' => 'register-submit btn btn-primary btn-lg', 'id' => 'register-submit', 'tabindex' => '4')) !!}
      {!! Form::close() !!}
      
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/moment/min/moment.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/moment/locale/pt-br.js')}}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
  <link rel="stylesheet" href="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" />
  <script src="{{ asset('bower_components/moment/locale/fr.js')}}"></script>
  <script type="text/javascript" src="{{ asset('js/datepicker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/parsely.min.js') }}"></script>
@endsection
