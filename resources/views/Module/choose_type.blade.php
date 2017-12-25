@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Declare second quality garmnet<span class="pull-right">Majstorica: <b>{{$leader}}</b></span></div>
				
				{{-- 
				{!! Form::open(['method'=>'POST', 'url'=>'/choose_type']) !!}
				<meta name="csrf-token" content="{{ csrf_token() }}" />

				<div class="panel-body">
					<p>Second quality Type (Color of bag) </p>
					{!! Form::select('type', array(''=>'','Blue'=>'Blue','Yellow'=>'Yellow','Red'=>'Red'), '', array('class' => 'form-control')) !!} 
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success center-block']) !!}
				</div>

				@include('errors.list')
				{!! Form::close() !!}

				--}}

				<div class="panel-body">
					<div class="">
						<a href="{{url('/choose_type/BLUE')}}" class="btn btn-c1 center-block">BLUE</a>
					</div>
				</div>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/choose_type/YELLOW')}}" class="btn btn-c2 center-block">YELLOW</a>
					</div>
				</div>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/choose_type/RED')}}" class="btn btn-c3 center-block">RED</a>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</div>
@endsection