@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Declare second quality garmnet<span class="pull-right">Majstorica: <b>{{$leader}}</b></span></div>
				
				{!! Form::open(['method'=>'POST', 'url'=>'/choose_order']) !!}
				<meta name="csrf-token" content="{{ csrf_token() }}" />

				<div class="panel-body">
					<p>Po/Komesa: </p>
					{!! Form::number('po', null, ['id' => 'po', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				<div class="panel-body">
					<p>Size/Velicina: </p>
					{!! Form::select('size', array(''=>'','XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','XXL'=>'XXL','M/L'=>'M/L','S/M'=>'S/M','XS/S'=>'XS/S','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','3-4'=>'3-4','5-6'=>'5-6','7-8'=>'7-8','9-10'=>'9-10','11-12'=>'11-12','LSHO'=>'LSHO','SSHO'=>'SSHO','MSHO'=>'MSHO','XSSHO'=>'XSSHO','TU'=>'TU','SSHO'=>'SSHO','MSHO'=>'MSHO','XSSHO'=>'XSSHO','SSHO'=>'SSHO','MSHO'=>'MSHO','XSSHO'=>'XSSHO'), '', array('class' => 'form-control')) !!} 
				</div>
				<div class="panel-body">
					<p>Quantity: </p>
					{!! Form::number('qty', null, ['class' => 'form-control']) !!}
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success center-block']) !!}
				</div>

				@include('errors.list')
				{!! Form::close() !!}

				@if(isset($msg))
				        <ul class='alert alert-danger'>
							<li>{{ $msg }}</li>
						</ul>
				@endif
			
			</div>
		</div>
	</div>
</div>
@endsection