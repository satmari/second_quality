@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Transfer bag: Scan Bag barcode</div>
				<br>
					@if(isset($msgs))
						<div class="alert alert-success" role="alert">
						  {{ $msgs }}
						</div>
					@endif

					@if(isset($msge))
						<div class="alert alert-danger" role="alert">
						  {{ $msge }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/transfer_bag']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

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

					
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection