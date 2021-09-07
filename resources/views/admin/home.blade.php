<x-app-layout>
<x-menu-sanfona />
<x-area-conteudo-admin-coordenador />
@once
    @push('scripts')
        <script>
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
    @endpush
@endonce
</x-app-layout>
