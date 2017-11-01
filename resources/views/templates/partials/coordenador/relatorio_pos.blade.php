@extends('templates.default')

@section('relatorio_pos')
  <form action="" method="POST">
    <legend>Relatório de inscritos</legend>
	    <table class="table table-striped">
		  	<thead>
			    <tr>
			      <th>Edital</th>
			      <th>Programa</th>
			      <th>Período de Inscrição</th>
			      <th>Relatório de Inscritos</th>
			      <th>Lista de Inscritos</th>
			    </tr>
		  	</thead>
		  	<tbody>
			    	<tr>
			      	<th scope="row"><a href="{!! route('gera.relatorio', ['id_inscricao_pos' => $relatorio_disponivel['id_inscricao_pos']]) !!}">{{$relatorio_disponivel['edital']}}</a></th>
			      	<td><a href="{!! route('gera.relatorio', ['id_inscricao_pos' => $relatorio_disponivel['id_inscricao_pos']]) !!}">{{ $programa }}</a></td>
			      	<td><a href="{!! route('gera.relatorio', ['id_inscricao_pos' => $relatorio_disponivel['id_inscricao_pos']]) !!}">{{\Carbon\Carbon::parse($relatorio_disponivel['inicio_inscricao'])->format('d/m/Y')." à ".\Carbon\Carbon::parse($relatorio_disponivel['fim_inscricao'])->format('d/m/Y')}}</a></td>
			      	<td>@if($monitoria == $relatorio_disponivel['id_inscricao_pos']) <a target="_blank" href="{{asset('relatorios/csv/'.$arquivo_relatorio)}}" >{{$arquivo_relatorio}}</a> @endif</td>
			      	<td>@if($monitoria == $relatorio_disponivel['id_inscricao_pos']) <a target="_blank" href="{{asset('relatorios/zip/'.$documentos_zipados)}}">{{$documentos_zipados}}</a> @endif</td>
			    	</tr>
		  	</tbody>
		</table>
  </form>
@stop