@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Create new shipment</div>
				<!-- <br> -->
					
					
					@if (isset($msg))
						<div class="alert alert-danger" role="alert">
							{{ $msg }}
						</div>
					@endif

					{!! Form::open(['method'=>'POST', 'url'=>'/add_new_shipment_post']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
						

						<div class="panel-body">
						<p>Shipment:  <span style="color:red;">*</span></p>
							{!! Form::text('shipment', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>

						<br>
						<div class="panel-body">
						<p>Approval no: </p>
							{!! Form::text('approval', null, ['class' => 'form-control']) !!}
						</div>

						<br>
						{!! Form::submit('Create', ['class' => 'btn  btn-success center-block']) !!}
						@include('errors.list')

						{!! Form::close() !!}
					<!-- <hr> -->
					<br>

					
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection