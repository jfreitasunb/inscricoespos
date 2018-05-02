@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('visualiza_associacoes')

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Recomendantes indicados por candidato</legend>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>E-mail preferido</th>
          <th>E-mail informado</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($paginatedItems as $key => $associacao)
          <tr>
            <td>{{ $key }}</td>
            <td>  
              @foreach ($associacao as $email)
                {{ $email }}</br><hr>
              @endforeach
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="text-center">
    {{ $paginatedItems->render() }}
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