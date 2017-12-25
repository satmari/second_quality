@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Create new Request for: {{$po}}<span class="pull-right">Majstorica: <b>{{$leader}}</b></span></div>
				
				{!! Form::open(['method'=>'POST', 'url'=>'/requeststoretreb']) !!}
				<meta name="csrf-token" content="{{ csrf_token() }}" />

				{!! Form::hidden('leader', $leader, ['class' => 'form-control']) !!}
				{!! Form::hidden('so', $so, ['class' => 'form-control']) !!}
				{!! Form::hidden('po', $po, ['class' => 'form-control']) !!}
				{!! Form::hidden('itemfg', $itemfg, ['class' => 'form-control']) !!}
				{!! Form::hidden('colorfg', $colorfg, ['class' => 'form-control']) !!}
				{!! Form::hidden('sizefg', $sizefg, ['class' => 'form-control']) !!}

				<div class="panel-body">

				@foreach ($newarray as $line)
			    <div class="checkbox">
			    	<label style="width: 100%;" type="button" class="btn check btn-default"  data-color="primary">
			      		<input type="checkbox" class="btn check" name="items[]" value="{{ $line['item'].'#'.$line['item_t'].'#'.$line['color'].'#'.$line['color_t'].'#'.$line['size'].'#'.$line['size_t'].'#'.$line['uom'].'#'.$line['hu']}}">  

			      		{{ $line['item_t'] }}

						@if (($line['item_t'] == 'Kuma') OR ($line['item_t'] == 'Elan'))
								{{ $line['color_t'] }}
						@endif
						
						{{ $line['size_t'] }}

			    	</label>
			  	</div>
			  	@endforeach
			  	<div class="checkbox">
			    	<label style="width: 30%;" type="button" class="btn check btn-warrning"  data-color="info">
			      		<input type="checkbox" class="btn check" id="checkAll"><b>Izaberi sve</b>
			    	</label>
			  	</div>
					

			    <div class="panel-body">
			    	<p>Comment:</p>
				    {!! Form::text('comment', null, ['class' => 'form-control']) !!}
				</div>				    

				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success center-block']) !!}
				</div>

				@include('errors.list')
				{!! Form::close() !!}

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