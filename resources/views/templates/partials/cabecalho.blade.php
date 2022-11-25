<header id="header">
	<div class="grid grid-cols-1">
		<div class="bg-azul-MAT lg:flex flex-grow lg:items-center p-8 sm:p-12">
			<div class="flex-grow">
				<a href="{{URL::to('/')}}"> <img src="{{ asset('imagens/logo/logo_unb.png') }}" alt="Logo do MAT-UnB" class="sm:flex-shrink-0 mx-auto sm:mx-0 h-24" style="height:120px" /></a>
				<div class="xm:ml-4 sm:text-left text-center">
        				<h1 class="text-white text-center text-2xl sm:text-5xl mb-2">Departamento de Matemática</h1>
	                		<h2 class="text-white text-center text-2xl sm:text-5xl mb-2">Inscrições para o Mestrado e Doutorado</h2>
					<h3 class="text-white text-center text-2xl sm:text-5xl mb-2">22/11/2022 à 22/01/2023</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="flex justify-center items-center mt-12">
		<div class="grid grid-cols-3 gap-4">
			<div class="mt-4">
				<button type="button" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
					Português
				</button>
			</div>
			<div class="mt-4 pl-2">
				<button type="button" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
					English
				</button>
			</div>
			<div class="mt-4 pl-2">
				<button type="button" class="bg-azul-MAT text-white hover:text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-full text-xs lg:text-xl px-6 lg:px-32 py-1 focus-outline-none">
					Español
				</button>
			</div>
		</div>
	</div>
	<div class="flex justify-center items-center mt-12 lg:mt-44">
		<div class="grid grid-cols-2 gap-4">
			<div class="mt-4 sm:pl-4">
				<button type="button" class="w-full bg-verde-MAT text-white border border-bg-azul-MAT hover:bg-green-700 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">
					Login	
				</button>
			</div>
			<div class="mt-4 sm:pl-4">
				<button type="button" class="bg-azul-MAT text-white border border-bg-azul-MAT hover:bg-sky-900 font-semibold rounded-md lg:text-4xl px-12 lg:px-40 py-1 focus-outline-none">
					Registrar
				</button>
			</div>
		</div>
	</div>

	<div class="flex justify-center items-center mt-8">
		<div class="flex items-center mt-4">
			<p class="items-center text-blue-500 hover:underline"><a href="#">Esqueceu a senha?</a>
		</div>
	</div>

</header>
