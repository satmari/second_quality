@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">2. Scan Bag:</div>
				<br>
					@if(isset($msg))
						<!-- <div class="alert alert-info" role="alert"> -->
						  <p>{{ $msg }}</p>
						<!-- </div> -->
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/scan_bag_multiple_location_scan']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('location', $location, ['class' => 'form-control']) !!}
						
						
						<div class="panel-body">
						<!-- <p>Scan Bag barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::text('bag', null, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>
						<br>
						{!! Form::submit('Add to list', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					<br>
					<br>
					
					@if (isset($bags) AND (!empty($bags)) )
					<div>
						
						<table  class="table">
							<thead>
								<th>Transfer scaned bags to <b>"{{ $location }}"</b></th>
								<th></th>
							</thead>
							<tbody>
							@foreach ($bags as $line)
							<tr>
								<td><big><big>{{ $line->bag }}</big></big></td>
								<td><span style="color:red">
									{!! Form::open(['method'=>'POST', 'url'=>'remove_multiple_location_scan']) !!}
										<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
										{!! Form::hidden('id', $line->id, ['class' => 'form-control']) !!}
										{!! Form::hidden('location', $location, ['class' => 'form-control']) !!}

										{!! Form::submit('X', ['class' => 'btn btn-xs btn-danger cen ter-block']) !!}
										@include('errors.list')
									{!! Form::close() !!}
								</span></td>
								
							</tr>
							@endforeach	
							</tbody>						
						</table>
						
					</div>
					
					<hr>
						
					 {!! Form::open(['method'=>'POST', 'url'=>'/scan_bag_multiple_location_post']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('location', $location, ['class' => 'form-control']) !!}

						{!! Form::submit('Confirm', ['class' => 'btn  btn-danger center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					<br>
					@endif
			</div>
		</div>
	</div>
</div>

@endsection