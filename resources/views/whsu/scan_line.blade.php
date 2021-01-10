@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">1. Scan Line barcode</div>
				<br>	
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
				
					{!! Form::open(['method'=>'POST', 'url'=>'/scan_line']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
						
						<div class="panel-body">
						<!-- <p>Scan Line barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::text('line', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>
						<br>
						{!! Form::submit('Continue', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				
				<!-- <hr> -->
				<br>
				
			</div>
		</div>
	</div>
</div>

@endsection