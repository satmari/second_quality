@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Print final box labels for shipment: {{ $shipment }}</div>
				<!-- <h3 style="color:re d;">Info</h3> -->

				<br>
				@if(isset($msg) AND ($msg != ''))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
				@endif

				@if(isset($msg_i) AND ($msg_i != ''))
						<div class="alert alert-success" role="alert">
						  {{ $msg_i }}
						</div>
				@endif
				<p>
					<span style='color:red'>Please check if label dimension in printer "Magacin" (kod Zlatka)!</span>
				</p>

				<div class="panel-body">
					<div class="">
					{!! Form::open(['method'=>'POST', 'url'=>'/print_export_shipment_post' ]) !!}
                        {!! Form::hidden('shipment', $shipment, ['class' => 'form-control']) !!}
                        {!! Form::hidden('approval', $approval, ['class' => 'form-control']) !!}

                        {!! Form::submit('Print Shipment', ['class' => 'btn btn-info btn-xL center-block']) !!}
                        @include('errors.list')
                    {!! Form::close() !!}
                </div>
                <br>
				<!-- <div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
					</div>
				</div> -->

			</div>
		</div>
	</div>
</div>

@endsection