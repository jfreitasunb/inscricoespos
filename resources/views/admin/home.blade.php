<x-app-layout>
<div class="mt-2 grid grid-cols-3 gap-x-3">
    <div class="w-auto py-3 bg-indigo-200 h-96 col-span-1">
<div class="w-full p-8 mx-auto md:w-3/5">
         <p>Open <strong>one</strong></p>
         <div class="shadow-md">
            <div class="w-full overflow-hidden border-t tab">
               <input class="absolute opacity-0" id="tab-single-one" type="radio" name="tabs2">
               <label class="block p-5 leading-normal cursor-pointer" for="tab-single-one">Label One</label>
               <div class="overflow-hidden leading-normal bg-gray-100 border-l-2 border-indigo-500 tab-content">
                  <p class="p-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, architecto, explicabo perferendis nostrum, maxime impedit atque odit sunt pariatur illo obcaecati soluta molestias iure facere dolorum adipisci eum? Saepe, itaque.</p>
               </div>
            </div>
            <div class="w-full overflow-hidden border-t tab">
               <input class="absolute opacity-0" id="tab-single-two" type="radio" name="tabs2">
               <label class="block p-5 leading-normal cursor-pointer" for="tab-single-two">Label Two</label>
               <div class="overflow-hidden leading-normal bg-gray-100 border-l-2 border-indigo-500 tab-content">
                  <p class="p-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, architecto, explicabo perferendis nostrum, maxime impedit atque odit sunt pariatur illo obcaecati soluta molestias iure facere dolorum adipisci eum? Saepe, itaque.</p>
               </div>
            </div>
            <div class="w-full overflow-hidden border-t tab">
               <input class="absolute opacity-0" id="tab-single-three" type="radio" name="tabs2">
               <label class="block p-5 leading-normal cursor-pointer" for="tab-single-three">Label Three</label>
               <div class="overflow-hidden leading-normal bg-gray-100 border-l-2 border-indigo-500 tab-content">
                  <p class="p-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur, architecto, explicabo perferendis nostrum, maxime impedit atque odit sunt pariatur illo obcaecati soluta molestias iure facere dolorum adipisci eum? Saepe, itaque.</p>
               </div>
            </div>
         </div>
        <button class="px-4 py-2 ml-2 font-semibold text-red-700 bg-transparent border border-red-500 rounded hover:bg-red-500 hover:text-white hover:border-transparent" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" type="submit">Sair<button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    </div>
    </div>

    <div class="py-10 mr-4 col-span-2">
        <h1 class="text-3xl font-bold">Olá</h1>
        <p class="mt-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempor ante diam, at dignissim sapien finibus nec. Suspendisse luctus accumsan velit nec maximus. Aliquam erat volutpat. Sed venenatis, felis eget vestibulum molestie, urna lacus ultrices eros, vitae semper nisl ex non ante. Morbi faucibus elit non leo placerat ultrices. Integer leo felis, malesuada in odio eget, convallis pellentesque magna. Suspendisse accumsan maximus lacus quis mattis. Integer fermentum dictum quam at ullamcorper. Pellentesque condimentum ex ac aliquet auctor. Pellentesque semper, leo eget convallis aliquet, nisi ligula viverra metus, molestie facilisis lorem turpis ac metus. Nulla euismod sagittis enim, non malesuada dui dapibus id.
        </p>
        <p class="mt-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempor ante diam, at dignissim sapien finibus nec. Suspendisse luctus accumsan velit nec maximus. Aliquam erat volutpat. Sed venenatis, felis eget vestibulum molestie, urna lacus ultrices eros, vitae semper nisl ex non ante. Morbi faucibus elit non leo placerat ultrices. Integer leo felis, malesuada in odio eget, convallis pellentesque magna. Suspendisse accumsan maximus lacus quis mattis. Integer fermentum dictum quam at ullamcorper. Pellentesque condimentum ex ac aliquet auctor. Pellentesque semper, leo eget convallis aliquet, nisi ligula viverra metus, molestie facilisis lorem turpis ac metus. Nulla euismod sagittis enim, non malesuada dui dapibus id.
        </p>
        <p class="mt-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempor ante diam, at dignissim sapien finibus nec. Suspendisse luctus accumsan velit nec maximus. Aliquam erat volutpat. Sed venenatis, felis eget vestibulum molestie, urna lacus ultrices eros, vitae semper nisl ex non ante. Morbi faucibus elit non leo placerat ultrices. Integer leo felis, malesuada in odio eget, convallis pellentesque magna. Suspendisse accumsan maximus lacus quis mattis. Integer fermentum dictum quam at ullamcorper. Pellentesque condimentum ex ac aliquet auctor. Pellentesque semper, leo eget convallis aliquet, nisi ligula viverra metus, molestie facilisis lorem turpis ac metus. Nulla euismod sagittis enim, non malesuada dui dapibus id.
        </p>
        <p class="mt-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempor ante diam, at dignissim sapien finibus nec. Suspendisse luctus accumsan velit nec maximus. Aliquam erat volutpat. Sed venenatis, felis eget vestibulum molestie, urna lacus ultrices eros, vitae semper nisl ex non ante. Morbi faucibus elit non leo placerat ultrices. Integer leo felis, malesuada in odio eget, convallis pellentesque magna. Suspendisse accumsan maximus lacus quis mattis. Integer fermentum dictum quam at ullamcorper. Pellentesque condimentum ex ac aliquet auctor. Pellentesque semper, leo eget convallis aliquet, nisi ligula viverra metus, molestie facilisis lorem turpis ac metus. Nulla euismod sagittis enim, non malesuada dui dapibus id.
        </p>
        <p class="mt-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempor ante diam, at dignissim sapien finibus nec. Suspendisse luctus accumsan velit nec maximus. Aliquam erat volutpat. Sed venenatis, felis eget vestibulum molestie, urna lacus ultrices eros, vitae semper nisl ex non ante. Morbi faucibus elit non leo placerat ultrices. Integer leo felis, malesuada in odio eget, convallis pellentesque magna. Suspendisse accumsan maximus lacus quis mattis. Integer fermentum dictum quam at ullamcorper. Pellentesque condimentum ex ac aliquet auctor. Pellentesque semper, leo eget convallis aliquet, nisi ligula viverra metus, molestie facilisis lorem turpis ac metus. Nulla euismod sagittis enim, non malesuada dui dapibus id.
        </p>
        <p class="mt-3">
            Vestibulum ornare, urna nec consequat gravida, diam odio auctor eros, in pharetra felis ipsum vulputate mauris. Vivamus odio diam, tristique eu bibendum ut, vehicula non justo. Integer dolor odio, imperdiet quis diam ac, volutpat interdum diam. Donec a ante sit amet dui consequat malesuada. Pellentesque sit amet blandit nunc. Maecenas id leo quis dui vestibulum facilisis. Maecenas non mollis odio. Donec varius justo ac egestas ullamcorper. Suspendisse quis felis id purus facilisis semper. Proin blandit diam arcu, in accumsan mi aliquam non. Curabitur mattis ipsum sed velit pharetra iaculis non sit amet velit. Phasellus commodo eros quis ex imperdiet luctus. Nullam varius suscipit dolor quis consectetur. In hac habitasse platea dictumst. Phasellus mattis, massa quis lacinia porttitor, lectus ante placerat turpis, id congue orci lorem vel mi. Donec bibendum, ipsum consectetur aliquam tristique, urna est varius elit, nec aliquam lacus nisi vitae metus.
        </p>
        <p class="mt-3">
            Vestibulum tempus, mi vitae cursus placerat, ex leo cursus purus, nec tincidunt magna nisi sed enim. Nullam consectetur, tellus nec volutpat tempus, tortor urna viverra libero, sed sodales sapien magna nec dolor. Nunc faucibus erat augue, ut faucibus ipsum aliquet a. Mauris ornare ipsum diam, vitae efficitur lectus lacinia nec. Duis quis tempus purus. Vestibulum eros lorem, varius in efficitur eu, ornare ut mauris. Donec lectus ligula, maximus a rhoncus ac, sodales quis neque. Cras ac laoreet purus. Nam imperdiet tortor eu nunc maximus ultrices. Nulla tincidunt rhoncus neque sed condimentum.
        </p><p class="mt-3">
            Vestibulum tempus, mi vitae cursus placerat, ex leo cursus purus, nec tincidunt magna nisi sed enim. Nullam consectetur, tellus nec volutpat tempus, tortor urna viverra libero, sed sodales sapien magna nec dolor. Nunc faucibus erat augue, ut faucibus ipsum aliquet a. Mauris ornare ipsum diam, vitae efficitur lectus lacinia nec. Duis quis tempus purus. Vestibulum eros lorem, varius in efficitur eu, ornare ut mauris. Donec lectus ligula, maximus a rhoncus ac, sodales quis neque. Cras ac laoreet purus. Nam imperdiet tortor eu nunc maximus ultrices. Nulla tincidunt rhoncus neque sed condimentum.
        </p><p class="mt-3">
            Vestibulum tempus, mi vitae cursus placerat, ex leo cursus purus, nec tincidunt magna nisi sed enim. Nullam consectetur, tellus nec volutpat tempus, tortor urna viverra libero, sed sodales sapien magna nec dolor. Nunc faucibus erat augue, ut faucibus ipsum aliquet a. Mauris ornare ipsum diam, vitae efficitur lectus lacinia nec. Duis quis tempus purus. Vestibulum eros lorem, varius in efficitur eu, ornare ut mauris. Donec lectus ligula, maximus a rhoncus ac, sodales quis neque. Cras ac laoreet purus. Nam imperdiet tortor eu nunc maximus ultrices. Nulla tincidunt rhoncus neque sed condimentum.
        </p><p class="mt-3">
            Vestibulum tempus, mi vitae cursus placerat, ex leo cursus purus, nec tincidunt magna nisi sed enim. Nullam consectetur, tellus nec volutpat tempus, tortor urna viverra libero, sed sodales sapien magna nec dolor. Nunc faucibus erat augue, ut faucibus ipsum aliquet a. Mauris ornare ipsum diam, vitae efficitur lectus lacinia nec. Duis quis tempus purus. Vestibulum eros lorem, varius in efficitur eu, ornare ut mauris. Donec lectus ligula, maximus a rhoncus ac, sodales quis neque. Cras ac laoreet purus. Nam imperdiet tortor eu nunc maximus ultrices. Nulla tincidunt rhoncus neque sed condimentum.
        </p>
    </div>
</div>
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
