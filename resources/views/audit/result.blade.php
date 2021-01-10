@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Bag info: <big><b>BAG: {{ $bag }}, PRO:{{ $pro }}, SKU: {{ $sap_sku }} ,Line: {{ $line }}, Approval: {{ $approval }}</b></big></div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/result_change_qty' ]) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />
						{!! Form::hidden('id', $id, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}

						@if(isset($msgs1))
							<div class="alert alert-success" role="alert">
							  {{ $msgs1 }}
							</div>
						@endif

						<div class="panel-body">
						<!-- <p>Scan Bag barcode:  <span style="color:red;">*</span></p> -->
							@if($qty_audit == 0)
								{!! Form::number('qty_audit', $qty, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
							@else
								{!! Form::number('qty_audit', $qty_audit, ['class' => 'form-control',  'autofocus' => 'autofocus']) !!}
							@endif
						</div>
						<br>
						{!! Form::submit('Change qty from line', ['class' => 'btn  btn-warning center-block']) !!}


						@include('errors.list')

					{!! Form::close() !!}

					<hr>

					{!! Form::open(['method'=>'POST', 'url'=>'/result_confirm']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('id', $id, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}

						@if($qty_audit == 0)
							{!! Form::hidden('qty_audit', $qty, ['class' => 'form-control']) !!}
						@else
							{!! Form::hidden('qty_audit', $qty_audit, ['class' => 'form-control']) !!}
						@endif
						
						<div class="panel-body">
						<p>Garment as 2nd quality:
							{!! Form::number('qty_2', $qty_2, ['class' => 'form-control']) !!}
						</div>
						<hr>
						<div class="panel-body">
						<p>Garment as 1nd quality (APPROVED TECHNICALY):
							{!! Form::number('qty_1_approved', $qty_1_approved, ['class' => 'form-control']) !!}
						</div>
						<div class="panel-body">
						<p>Garment as 1nd quality (REPAIRED)
							{!! Form::number('qty_1_repaired', $qty_1_repaired, ['class' => 'form-control']) !!}
						</div>
						<div class="panel-body">
						<p>Garment as 1nd quality (CLEANED)
							{!! Form::number('qty_1_cleaned', $qty_1_cleaned, ['class' => 'form-control']) !!}
						</div>
						<div class="panel-body">
						<p>Balance 
							{!! Form::number('balance', $balance, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
						</div>
						<div class="panel-body">
						<p>Coment
							{!! Form::text('coment', $coment, ['class' => 'form-control']) !!}
						</div>

						{!! Form::submit('Save', ['class' => 'btn  btn-danger center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}


					
					
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection

