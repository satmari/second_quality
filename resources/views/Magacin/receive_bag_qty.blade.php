@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Warehouse menu - recive bag quantity</div>

				{!! Form::open(['method'=>'POST', 'url'=>'/receive_bag']) !!}
				<meta name="csrf-token" content="{{ csrf_token() }}" />

				{!! Form::hidden('id', $id, ['class' => 'form-control']) !!}

				<div class="panel-body">
					<p>Module suggest quantity</p>
					{!! Form::number('received_qty', $module_qty, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
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