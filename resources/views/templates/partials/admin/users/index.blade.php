@extends('templates.default')

@section('datatable_users')
	<div class="containter">
		<div class="row">
			<div class="col-md-12">
				<data-table endpoint=" {{ route('users.index') }}"></data-table>
			</div>
		</div>
	</div>
@endsection