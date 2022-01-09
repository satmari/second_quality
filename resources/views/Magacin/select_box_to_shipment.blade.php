@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Choose Bag  to add on shipment <b>{{ $shipment }}</b> with approval <b>{{ $approval }}</b></div>
				<br>
					@if(isset($msg) AND ($msg != ''))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif

					@if(isset($msg_i))
						<div class="alert alert-success" role="alert">
						  {{ $msg_i }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/select_box_to_shipment_post']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('shipment', $shipment, ['class' => 'form-control']) !!}
						{!! Form::hidden('approval', $approval, ['class' => 'form-control']) !!}
						
						@if(isset($newarray))
							@foreach ($newarray as $line)
								<tr>
	  							<td style="width:100%">
	  								<div class="checkbox">
								    	<label style="width: 100%;" type="button" class="btn check btn-default"  data-color="primary">
								      		<input type="checkbox" class="btn check" name="boxes[]" value="{{ $line['box'] }}">  
								      		<input name="hidden[]" type='hidden' value="{{ $line['box'] }}"> 

								      		{{ $line['box'] }}
											-
											<small><i>
											{{ $line['style_2'] }} {{ $line['color_2'] }} {{ $line['size_2'] }} - {{ $line['box_qty'] }} pcs
											</i></small>

								    	</label>
								  	</div>
	  						 	</td>
	  						</tr>
							@endforeach

							<br>
							<div class="checkbox">
						    	<label style="width: 30%;" type="button" class="btn check btn-warrning"  data-color="info">
						      		<input type="checkbox" class="btn check" id="checkAll"><b>Izaberi sve</b>
						    	</label>
						  	</div>
							<br>

							{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}
							@include('errors.list')
							{!! Form::close() !!}

						@else

						<p><span style='color:red'>In box table not existi box with proper status (FULL/CLOSED) and approval that is same as shipment approval </span></p>

						@endif

						
					
					
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection