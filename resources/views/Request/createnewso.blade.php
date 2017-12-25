@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Create new Request<span class="pull-right">Majstorica: <b>{{$leader}}</b></span></div>
				
				{!! Form::open(['method'=>'POST', 'url'=>'/createnewso']) !!}
				<meta name="csrf-token" content="{{ csrf_token() }}" />

				<div class="panel-body">
					<p>Po/Komesa: </p>
					{!! Form::number('po', null, ['id' => 'po', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				<div class="panel-body">
					<p>Size/Velicina: </p>
					{!! Form::select('size', array(''=>'','XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','XXL'=>'XXL','M/L'=>'M/L','S/M'=>'S/M'), '', array('class' => 'form-control')) !!} 
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success center-block']) !!}
				</div>

				@include('errors.list')
				{!! Form::close() !!}
			
				
			</div>
		</div>
	</div>
</div>
@endsection