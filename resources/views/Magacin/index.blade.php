@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Warehouse menu</div>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/receive_bag_function')}}" class="btn btn-info center-block">Receive Bag</a>
					</div>
				</div>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-info center-block"></a>
					</div>
				</div>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-info center-block"></a>
					</div>
				</div>
				
				
			
			</div>
		</div>
	</div>
</div>
@endsection