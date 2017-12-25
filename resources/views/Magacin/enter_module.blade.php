@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Warehouse menu - enter/scan module</div>

				{!! Form::open(['method'=>'POST', 'url'=>'/enter_module']) !!}
				<meta name="csrf-token" content="{{ csrf_token() }}" />

				<div class="panel-body">
					<p>Module name</p>
					{!! Form::text('module', null, ['id' => 'po', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success center-block']) !!}
				</div>

				@include('errors.list')
				{!! Form::close() !!}
				
				
			
			</div>
		</div>
	</div>
</div>
@endsection