@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Scan Location:</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/scan_confirm_location']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('id', $id, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						
						<div class="panel-body">
						<!-- <p>Scan Bag barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::text('location', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>

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