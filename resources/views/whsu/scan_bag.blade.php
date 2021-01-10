@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">2. Scan Bag barcode:</div>
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
					
					{!! Form::open(['method'=>'POST', 'url'=>'/scan_bag']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}

						<div class="panel-body">
						<!-- <p>Scan Bag barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::text('bag', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>
						<br>
						{!! Form::submit('Continue', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					<!-- <hr> -->
					<br>
					<p><big><b>Info</b></big></p>
					<p>Line: {{ $line }}</p>
					<hr>
					<a href="{{ url('/scan_start') }}" class="btn btn-warning btn-x s center-b lock" >Change Line</a>
					<br>
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection