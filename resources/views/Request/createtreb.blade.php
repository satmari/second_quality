@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Create new Request<span class="pull-right">Majstorica: <b>{{$leader}}</b></span></div>
				
				
				<div class="panel-body">

				@foreach ($so as $line)
					<p><a href="{{url('/existingso/'.$line->so)}}" class="btn btn-default center-block">{{ $line->po }} - {{ $line->item }} - {{ $line->size }}</a></p>
				@endforeach

				</div>

				<div class="panel-body">
					<p><a href="{{url('/newso')}}" class="btn btn-success center-block">New Order</a></p>
				</div>
			
				{{--
				<hr>
				<div class="panel-body">
					<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
				</div>
				--}}
				
			</div>
		</div>
	</div>
</div>
@endsection