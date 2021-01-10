@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Edit box configuration</b></div>
				
				
					{!! Form::open(['url' => 'update_box/'.$data->id]) !!}
					
					<div class="panel-body">
						<p>Style:<span style="color:red;">*</span></p>
	               		{!! Form::input('string', 'style', $data->style, ['id'=>'st','class' => 'form-control','disabled' => 'disabled']) !!}
					</div>
					
					<div class="panel-body">
						<p>Color:<span style="color:red;">*</span></p>
	               		{!! Form::input('string', 'color', $data->color, ['id'=>'co','class' => 'form-control','disabled' => 'disabled']) !!}
					</div>
					
					<div class="panel-body">
						<p>Size:<span style="color:red;">*</span></p>
	               		{!! Form::input('string', 'size', $data->size, ['id'=>'si','class' => 'form-control','disabled' => 'disabled']) !!}
					</div>

					<div class="panel-body">
						<p>Brand:<span style="color:red;">*</span></p>
	               		{!! Form::select('brand', array(''=>'','Intimissimi'=>'Intimissimi','Tezenis'=>'Tezenis','Calzedonia'=>'Calzedonia'), $data->brand, array('class' => 'form-control', 'disabled' => 'disabled')); !!} 
					</div>
					<hr>
					<b>
	               		<p>If you are missing below information (orange color),
	               		try to update (if exist) in Umesa file/table, <a href="http://172.27.161.173/settings/update_second_q_info">with this link</a>, it requires couple of minutes.
	               		 Call IT if they are still missing after update.</p>
	               	</b>
					<div class="panel-body">
						<p><span style="color:orange">Stis code (2Q): <b>{{$data->style_2}}</b></span></p>
						<p><span style="color:orange">Color (2Q): <b>{{$data->color_2}}</b></span></p>
						<p><span style="color:orange">Size (2Q): <b>{{$data->size_2}}</b></span></p>
						<p><span style="color:orange">Col Desc (2Q): <b>{{$data->col_desc_2}}</b></span></p>
						<p><span style="color:orange">Ean (2Q): <b>{{$data->ean_2}}</b></span></p>

					</div>
					<hr>
					<b>
						<p>This information (red color) you should update manualy like you did before in Excel file, usualy for Tezenis and Calzedonia brand.</p>
					</b>
					<div class="panel-body">
						<p><span style="color:red">Pcs per polybag (2Q):</span></p>
	               		{!! Form::input('number', 'pcs_per_polybag_2', $data->pcs_per_polybag_2, ['class' => 'form-control']) !!}
					</div>

					<div class="panel-body">
						<p><span style="color:red">Pcs per box (2Q):</span></p>
	               		{!! Form::input('number', 'pcs_per_box_2', $data->pcs_per_box_2, ['class' => 'form-control']) !!}
					</div>
					<br>
					<div class="panel-body">
						{!! Form::submit('Confirm', ['class' => 'btn btn-success btn center-block']) !!}
					</div>

					@include('errors.list')

					{!! Form::close() !!}

				
				<br>
				
			</div>
		</div>
	</div>
</div>
@endsection
