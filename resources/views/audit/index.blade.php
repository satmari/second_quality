@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Audit part of Second Quality application</div>
				<br>
				<br>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/audit_table')}}" class="btn btn-info center-block">Table</a>
					</div>
				</div>
				<br>
				<br>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/scan_bag')}}" class="btn btn-c2 center-block">Scan and check Bag</a>
					</div>
				</div>
				<br>
				<br>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/scan_bag_audit_info')}}" class="btn btn-c2 center-block">Scan Bag and show info</a>
					</div>
				</div>
				<br>
				<br>

				<div class="panel-body">
					<div class="">
						<a href="{{url('/transfer_to_subotica')}}" class="btn btn-c3 center-block">Transfer Bag from Kik to Su</a>
					</div>
				</div>
				


				
			
			</div>
		</div>
	</div>
</div>
@endsection