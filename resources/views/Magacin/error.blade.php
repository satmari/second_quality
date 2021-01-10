@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"></div>
				<h3 style="color:red;">Error!</h3>

				
				@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
				@endif

				@if(isset($style))
						<div class="alert alert-info" role="alert">
						  
						  
						  {!! Form::open(['method'=>'POST', 'url'=>'edit_box2' ]) !!}
                                {!! Form::hidden('style', $style, ['class' => 'form-control']) !!}
                                {!! Form::hidden('color', $color, ['class' => 'form-control']) !!}
                                {!! Form::hidden('size', $size, ['class' => 'form-control']) !!}

                                {!! Form::submit('Edit box configuration', ['class' => 'btn btn-info btn-xs center-block ']) !!}
                                @include('errors.list')
                            {!! Form::close() !!}
						</div>
				@endif


				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection