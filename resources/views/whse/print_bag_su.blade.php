@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Print Bag barcode for Subotica</div>
				<!-- <br> -->
					
					
					<div class="alert alert-danger" role="alert">
					  <p>In selected printer label shoud be with dimension 4x5 in two rows!</p>
					  <p>From and To => write only last numbers</p>
					  <p>Please do not print labels that are already used, it is not possible to scan.</p>

					</div>

					{!! Form::open(['method'=>'POST', 'url'=>'/print_bag_su_confirm']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
							<p>Label: </p>
						<div class="panel-body">
							{!! Form::select('labels', array('BS'=>'BS','BL'=>'BL','BK'=>'BK','BZ'=>'BZ','BOX'=>'BOX'), null, array('class' => 'form-control')); !!} 
						</div>

						<div class="panel-body">
							<p>Printer:</p>
							{!! Form::select('printer_name', array(''=>'','Preparacija Zebra'=>'Preparacija Zebra','Magacin'=>'Magacin','Druga klasa ZEBRA' => 'Druga klasa ZEBRA'), null, array('class' => 'form-control')); !!} 
						</div>

						<div class="panel-body">
						<p>From:  <span style="color:red;">*</span></p>
							{!! Form::number('from', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>

						<div class="panel-body">
						<p>To:  <span style="color:red;">*</span></p>
							{!! Form::number('to', null, ['class' => 'form-control']) !!}
						</div>

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