@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Choose printer</div>
				

				<div class="panel-body">
					<div class="">
							
						{!! Form::open(['method'=>'POST', 'url'=>'/printer_set']) !!}
		
							<div class="panel-body">
								{!! Form::select('printer_name', array(''=>'','Krojacnica'=>'Krojacnica','Magacin'=>'Magacin','SBT-WP01'=>'SBT-WP01','SBT-WP02'=>'SBT-WP02','SBT-WP03'=>'SBT-WP03','SBT-WP04'=>'SBT-WP04','SBT-WP05'=>'SBT-WP05','SBT-WP06'=>'SBT-WP06'), null, array('class' => 'form-control')); !!} 
							</div>
							<br>

							{!! Form::submit('Set printer', ['class' => 'btn  btn-success center-block']) !!}

							@include('errors.list')

						{!! Form::close() !!}

						<hr>
						
    						<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection