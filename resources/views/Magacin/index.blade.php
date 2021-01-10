@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Magacin part of Second Quality application</div>
				<br>
				<br>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/magacin')}}" class="btn btn-c1 center-block">Bag</a>
					</div>
				</div>
				<br>
				<br>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/magacin_box')}}" class="btn btn-c2 center-block">Box</a>
					</div>
				</div>
				<br>
				<br>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/magacin_shipment')}}" class="btn btn-c3 center-block">Shipment</a>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</div>
@endsection