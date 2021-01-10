@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">2a. Choose line shft:</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					<div class="panel-body">
					{!! Form::open(['method'=>'POST', 'url'=>'/choose_line_shift']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', 'A', ['class' => 'form-control']) !!}

						{!! Form::submit('A', ['class' => 'btn shifta btn-suc cess center-block']) !!}

						@include('errors.list')
					{!! Form::close() !!}

					<br>

					{!! Form::open(['method'=>'POST', 'url'=>'/choose_line_shift']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', 'B', ['class' => 'form-control']) !!}

						{!! Form::submit('B', ['class' => 'btn shiftb btn-i nfo center-block']) !!}

						@include('errors.list')
					{!! Form::close() !!}

					<br>

					
					
					<!-- <hr> -->
					<br>
					<p><big><b>Info</b></big></p>
					<p>Line: {{ $line }}</p>
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection