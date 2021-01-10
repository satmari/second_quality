@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Close shipment</div>
				<br>
					@if (isset($empty))

					<div class="alert alert-danger" role="alert">
						  Shipment {{ $shipment }} doesn't contain any box, do you want to delete this shipment?
					</div>
					{!! Form::open(['method'=>'POST', 'url'=>'/close_shipment_confirm_delete']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
						{!! Form::hidden('id', $shipment_id, ['class' => 'form-control']) !!}
						{!! Form::hidden('shipment', $shipment,  ['class' => 'form-control']) !!}
						
						
						<br>
						{!! Form::submit('Delete shipment', ['class' => 'btn  btn-danger center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}					
					

					@else

					<div class="alert alert-danger" role="alert">
						  Close Shipment and for all boxes in shipment set status SHIPPED?
					</div>
					{!! Form::open(['method'=>'POST', 'url'=>'/close_shipment_confirm']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
						{!! Form::hidden('id', $shipment_id, ['class' => 'form-control']) !!}
						{!! Form::hidden('shipment', $shipment,  ['class' => 'form-control']) !!}
						
						
						<br>
						{!! Form::submit('Close shipment', ['class' => 'btn  btn-danger center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}

					@endif
					
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection