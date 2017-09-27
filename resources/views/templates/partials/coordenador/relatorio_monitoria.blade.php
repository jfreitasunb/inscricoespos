@extends('templates.default')

@section('relatorio_monitoria')
  <form action="" method="POST">
    <legend>Relatório de inscritos</legend>
	    <table class="table table-striped">
		  	<thead>
			    <tr>
			      <th>Id Monitoria</th>
			      <th>Ano/Semestre</th>
			      <th>Período de Inscrição</th>
			      <th>Relatório de Inscritos</th>
			      <th>Documentos</th>
			      <th>Dados Pessoais/Bancários</th>
			    </tr>
		  	</thead>
		  	<tbody>
		  		@foreach($relatorio_disponivel as $relatorio)
			    	<tr>
			      	<th scope="row"><a href="{!! route('gera.relatorio', ['id_monitoria' => $relatorio->id_monitoria]) !!}">{{$relatorio->id_monitoria}}</a></th>
			      	<td><a href="{!! route('gera.relatorio', ['id_monitoria' => $relatorio->id_monitoria]) !!}">{{$relatorio->ano_monitoria."/".$relatorio->semestre_monitoria}}</a></td>
			      	<td><a href="{!! route('gera.relatorio', ['id_monitoria' => $relatorio->id_monitoria]) !!}">{{\Carbon\Carbon::parse($relatorio->inicio_inscricao)->format('d/m/Y')." à ".\Carbon\Carbon::parse($relatorio->fim_inscricao)->format('d/m/Y')}}</a></td>
			      	<td>@if($monitoria == $relatorio->id_monitoria) <a target="_blank" href="{{asset('relatorios/csv/'.$arquivo_relatorio)}}" >{{$arquivo_relatorio}}</a> @endif</td>
			      	<td>@if($monitoria == $relatorio->id_monitoria) <a target="_blank" href="{{asset('relatorios/zip/'.$documentos_zipados)}}">{{$documentos_zipados}}</a> @endif</td>
			      	<td>@if($monitoria == $relatorio->id_monitoria) <a target="_blank" href="{{asset('relatorios/csv/'.$arquivo_dados_pessoais_bancario)}}" >{{$arquivo_dados_pessoais_bancario}}</a> @endif</td>
			    	</tr>
		    	@endforeach
		  	</tbody>
		</table>
		<div class="text-center">
			{!! $relatorio_disponivel->links(); !!}
		</div>
  </form>
@stop
