@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">Choose correct PRO/KOMESA for <b><big>{{ $bag }}</big></b></div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/change_bag_po_confirm']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_id', $bag_id, ['class' => 'form-control']) !!}

						<div class="panel-body">
							<p>PRO/Komesa:</p>
							{!! Form::text('proo', null, ['id' => 'po', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>


						<br>
						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					<!-- <hr>					 -->
					<br>
					
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection