@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Set weigth?</div>
				

				<div class="panel-body">
					<div class="">
							
						{!! Form::open(['method'=>'POST', 'url'=>'set_weigth']) !!}
							
							{!! Form::hidden('printer', $printer, ['class' => 'form-control']) !!}

							<div class="panel-body">
								
								{!! Form::input('number', 'print_qty' ,null, ['step' => '0.01', 'class' => 'form-control',  'autofocus' => 'autofocus']) !!}

							</div>
							
							<br>

							{!! Form::submit('Print', ['class' => 'btn  btn-success center-block']) !!}

							@include('errors.list')

						{!! Form::close() !!}
						<hr>
							<big><b><p>Selected priter is: {{ $printer }}</p></b></big>
							<br>
    						<a href="{{url('/diff_printer')}}" class="btn btn-default center-block">Choose different printer</a>
    						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection