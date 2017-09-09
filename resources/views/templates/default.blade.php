<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <title>Inscrições Monitoria do MAT/UnB</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/css_monitoria.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

  @yield('stylesheets')
</head>
<body>
  @include('templates.partials.alertas_erros')
  @include('templates.partials.cabecalho')
  <div class="container">
    @if (Auth::check())
      {{-- @include($templatemenu) --}}
      @if (Session::has('user_type') && Session::get('user_type')==='aluno')
        @include('templates.partials.candidato.menu_aluno')
        @yield('dados_pessoais')
        @yield('dados_bancarios')
        @yield('dados_academicos')
        @yield('escolha_monitoria')
      @endif
      @if (Session::has('user_type') && Session::get('user_type')==='coordenador')
        @include('templates.partials.coordenador.menu_coordenador')
        @yield('cadastra_disciplina')
        @yield('configura_monitoria')
        @yield('relatorio_monitoria')
      @endif
      @if (Session::has('user_type') && Session::get('user_type')==='admin')
        @include('templates.partials.admin.menu_admin')
        @yield('ativa_conta')
        @yield('cadastra_disciplina')
        @yield('configura_monitoria')
        @yield('relatorio_monitoria')
      @endif
    @else
      @yield('inicio')
      @yield('content')
    @endif
  </div>
  @include('templates.partials.rodape')
</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="{{ asset('jquery/jquery-3.1.1.min.js') }}"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/monitoria.js') }}"></script>
  <script src="{{ asset('bower_components/sweetalert2/dist/sweetalert2.min.js') }}"></script>
  
  <script>
    @if (notify()->ready())
      swal({
        title: "{!! notify()->message() !!}",
        type: "{!! notify()->type() !!}",
        @if (notify()->option('timer'))
            timer: {{ notify()->option('timer') }},
        @endif
        @if (notify()->option('showCancelButton'))
            showCancelButton: {!! notify()->option('showCancelButton') !!},
        @endif
        @if (notify()->option('confirmButtonColor'))
            confirmButtonColor: "{!! notify()->option('confirmButtonColor') !!}",
        @endif
        @if (notify()->option('cancelButtonColor'))
            cancelButtonColor: "{!! notify()->option('cancelButtonColor') !!}",
        @endif
        @if (notify()->option('confirmButtonText'))
            confirmButtonText: "{!! notify()->option('confirmButtonText') !!}",
        @endif
        @if (notify()->option('cancelButtonText'))
            cancelButtonText: "{!! notify()->option('cancelButtonText') !!}",
        @endif
      })@if (notify()->option('notifica'))
            .then(function () {
              swal(
                '{!! notify()->option('notifica_texto') !!}',
                '{!! notify()->option('notifica_mensagem') !!}',
                '{!! notify()->option('notifica_tipo') !!}',
              )
            })
        @endif
      @if (notify()->option('confirmacao'))
            .then(function () {
    $.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

  $.ajax({
              type: 'GET',
              url: '{{ notify()->option('rota') }}',
              data: {mudar: 1},
      });
}, function (dismiss) {
  // dismiss can be 'cancel', 'overlay',
  // 'close', and 'timer'
  if (dismiss === 'cancel') {
    $.ajax({
              type: 'GET',
              url: '{{ notify()->option('rota') }}',
              data: {
                mudar: false
          },
      });
  }
})
      @endif
        ;
    @endif
  </script>

  <script>

    var has_errors = {{ $errors->count()>0 ? 'true' : 'false'}};

    if (has_errors){
      swal({
        title: 'ERRO',
        type: 'error',
        html: jQuery("#ERRORS_COPY").html(),
        showCloseButton: true,
      })
    }
  </script>
  
  @yield('scripts')
  {{-- @yield('post-script') --}}

</html>
