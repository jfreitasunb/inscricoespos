<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscrições Pós Graduação MAT/UnB</title>

    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </head>

    <body>
        <div class="flex flex-col justify-between h-auto bg-gray-300">
            <x-header :message="$periodo_inscricao" />
            @guest
                <div class="h-30">
                <x-idiomas :idioma="$idioma" />
                </div>
            @endguest
            @if (Route::currentRouteName() == "home")
                <div class="mt-40 mb-72">
                <x-tela-login-registrar />
                </div>
            @endif
            @if (Route::currentRouteName() !== "home")
                <div class="font-sans antialiased text-gray-900">
                    {{ $slot }}
                </div>
            @endif

            <x-footer />
        </div>
     <script>
      /* Optional Javascript to close the radio button version by clicking it again */
      var myRadios = document.getElementsByName('tabs2');
      var setCheck;
      var x = 0;
      for(x = 0; x < myRadios.length; x++){
          myRadios[x].onclick = function(){
              if(setCheck != this){
                   setCheck = this;
              }else{
                  this.checked = false;
                  setCheck = null;
          }
          };
      }
   </script>
    </body>
</html>
