@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Add bag to box</div>
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
					
					{!! Form::open(['method'=>'POST', 'url'=>'/add_bag_to_box']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						
						<div class="panel-body">
						<p>Scan Bag barcode:  </p>
							{!! Form::text('bag', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>
						<br>
						{!! Form::submit('Continue', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection