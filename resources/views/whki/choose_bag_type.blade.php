@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">3. Choose bag type:</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					<div class="panel-body">
					{!! Form::open(['method'=>'POST', 'url'=>'/choose_bag_type_k']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', $line_shift, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_type', 'yellow', ['class' => 'form-control']) !!}

						{!! Form::submit('   Yellow  ', ['class' => 'btn by btn-suc cess center-block']) !!}

						@include('errors.list')
					{!! Form::close() !!}

					<br>

					{!! Form::open(['method'=>'POST', 'url'=>'/choose_bag_type_k']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', $line_shift, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_type', 'blue', ['class' => 'form-control']) !!}

						{!! Form::submit('       Blue      ', ['class' => 'btn bb btn-i nfo center-block']) !!}

						@include('errors.list')
					{!! Form::close() !!}

					<br>

					{!! Form::open(['method'=>'POST', 'url'=>'/choose_bag_type_k']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', $line_shift, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_type', 'red', ['class' => 'form-control']) !!}

						{!! Form::submit('Red', ['class' => 'btn br btn-dan ger center-block']) !!}

						@include('errors.list')
					{!! Form::close() !!}

					<br>

					{!! Form::open(['method'=>'POST', 'url'=>'/choose_bag_type_k']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', $line_shift, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_type', 'white', ['class' => 'form-control']) !!}

						{!! Form::submit('White', ['class' => 'btn bw btn-d efault center-block']) !!}

						@include('errors.list')
					{!! Form::close() !!}
					</div>

					
					<!-- <hr> -->
					<br>
					<p><big><b>Info</b></big></p>
					<p>Line: {{ $line }}, Shift: {{ $line_shift }}</p>
					<p>Bag: {{ $bag }}</p>
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection