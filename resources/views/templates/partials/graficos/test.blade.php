@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('graficos')

{!! Charts::styles() !!}

<div class="app">
    <center>
        {!! $chart->html() !!}
    </center>

    <hr>
    <center>
        {!! $chart2->html() !!}
    </center>
</div>
<!-- End Of Main Application -->
{!! Charts::scripts() !!}
{!! $chart->script() !!}
{!! $chart2->script() !!}

@endsection