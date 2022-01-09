@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Scan <b><big>BOX</big><big> barcode:</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-success" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/scan_box_location_1']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						
						<div class="panel-body">
						<!-- <p>Scan Bag barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::text('box', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>
						<br>
						{!! Form::submit('Next', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					<br>
				<!-- <hr> -->
			</div>
		</div>
	</div>
</div>

@endsection