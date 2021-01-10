@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Print Bag barcode for Kikinda</div>
				<!-- <br> -->
					
					<div class="alert alert-warning" role="alert">
					 
					 	Are you sure to print {{ $numberoflabels }} label/s on printer {{ $printer }} ?
					  
					</div>
					
					{!! Form::open(['method'=>'POST', 'url'=>'/print_bag_ki_confirm_print']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('printer', $printer, ['class' => 'form-control']) !!}
						{!! Form::hidden('from', $from, ['class' => 'form-control']) !!}
						{!! Form::hidden('to', $to, ['class' => 'form-control']) !!}
						<br>
						{!! Form::submit('Print', ['class' => 'btn  btn-success center-block']) !!}
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