@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Are you sure to Cancel bag <b><big>{{ $bag }}</big></b>:</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/cancel_confirm']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('bag_id', $bag_id, ['class' => 'form-control']) !!}
						
						{!! Form::submit('Confirm', ['class' => 'btn  btn-danger center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection