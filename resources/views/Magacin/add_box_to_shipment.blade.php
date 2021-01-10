@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Scan Bag barcode to add on shipment <b>{{ $shipment }}</b> with approval <b>{{ $approval }}</b></div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif

					@if(isset($msg_i))
						<div class="alert alert-success" role="alert">
						  {{ $msg_i }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/add_box_to_shipment_post']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('shipment', $shipment, ['class' => 'form-control']) !!}
						{!! Form::hidden('approval', $approval, ['class' => 'form-control']) !!}
						
						<div class="panel-body">
						<!-- <p>Scan Bag barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::text('box', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>
						<br>
						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection