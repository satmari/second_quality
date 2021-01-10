@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">2b. Scan Bag barcode:</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					@if(isset($msgs))
						<div class="alert alert-success" role="alert">
						  {{ $msgs }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/scan_bag_k']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', $line_shift, ['class' => 'form-control']) !!}

						<div class="panel-body">
						<!-- <p>Scan Bag barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::text('bag', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>

						{!! Form::submit('Continue', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					<!-- <hr> -->
					<br>
					<p><big><b>Info</b></big></p>
					<p>Line: {{ $line }}, Shift: {{ $line_shift }}</p>
					<hr>
					<a href="{{ url('/scan_start_k') }}" class="btn btn-warning btn-x s center-b lock" >Change Line</a>
					<br>
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection