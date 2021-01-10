@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">5. Inset quantity of FG in bag</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/confirm_k']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', $line_shift, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_type', $bag_type , ['class' => 'form-control']) !!}
						{!! Form::hidden('pro', $pro , ['class' => 'form-control']) !!}
						{!! Form::hidden('sap_sku', $sap_sku , ['class' => 'form-control']) !!}
						{!! Form::hidden('app', $app , ['class' => 'form-control']) !!}

						<div class="panel-body">
						<!-- <p>Scan Line barcode:  <span style="color:red;">*</span></p> -->
							{!! Form::number('qty', null,  ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
						</div>

						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					<!-- <hr>					 -->
					<br>
					<p><big><b>Info</b></big></p>
					<p>Line: {{ $line }}, Shift: {{ $line_shift }}</p>
					<p>Bag: {{ $bag }}</p>
					<p>Bag type: {{ $bag_type }}</p>
					<p>Pro: {{ $pro }}</p>
					<p>Sku: {{ $sap_sku }}</p>
					<p>Approval: {{ $app }}</p>
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection