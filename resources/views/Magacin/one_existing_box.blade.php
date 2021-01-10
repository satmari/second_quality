@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Fill existing BOX <br>
					<i><b>(1 step remain)</b></i></div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					@if(isset($msg_i))
						<div class="alert alert-info" role="alert">
						  {{ $msg_i }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/one_existing_box_post']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('style_2', $style_2, ['class' => 'form-control']) !!}
						{!! Form::hidden('approval', $approval, ['class' => 'form-control']) !!}
						{!! Form::hidden('box_qty_standard', $box_qty_standard, ['class' => 'form-control']) !!}
						{!! Form::hidden('box_qty', $box_qty, ['class' => 'form-control']) !!}
						{!! Form::hidden('no_of_boxes', $no_of_boxes, ['class' => 'form-control']) !!}
						{!! Form::hidden('no_of_boxes_orig', $no_of_boxes_orig, ['class' => 'form-control']) !!}
						{!! Form::hidden('existing_box_qty', $existing_box_qty, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_id', $bag_id, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}

						{!! Form::hidden('bag_qty', $bag_qty, ['class' => 'form-control']) !!}
						{!! Form::hidden('box_id', $box_id, ['class' => 'form-control']) !!}
						{!! Form::hidden('box', $box, ['class' => 'form-control']) !!}

						<div class="alert alert-info" role="alert">
							<p>Box <b>{{ $box }}</b> was found with proper STIS code <b>{{ $style_2 }}</b> and approval <b>{{ $approval }}</b>, 
							confirm to combine this bag <b>{{$bag}}</b> and box <b>{{$box}}</b> ?</p>  
						</div>
						

						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection