@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Edit box configuration</b></div>
				
				
					{!! Form::open(['url' => 'update_box2/'.$data->id]) !!}
					<br>
					<div class="panel-body">
						<b>
						</b><p><span style="color:">Style: <b>{{$data->style}}</b></span></p>
						<p><span style="color:">Color: <b>{{$data->color}}</b></span></p>
						<p><span style="color:">Size: <b>{{$data->size}}</b></span></p>
						<p><span style="color:">Brand: <b>{{$data->brand}}</b></span></p>
						</b>
					</div>
					
					<hr>
					<b>
	               		<p>If you are missing below information (orange color),
	               		try to update from Umesa file/table, <a href="http://172.27.161.173/settings/update_second_q_info">with this link</a>, it requires couple of minutes.
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
						<p>Material with same Stis code (2Q) + Color (2Q) + Size (2Q):</p>
						</b>
						@if(isset($data_2))


							@foreach ($data_2 as $line)
								@if ($line->brand == 'Intimissimi')
									<p>{{$line->material}} -> <b>Pcs per polybag: <big><span style="color:red">{{$line->pcs_per_polybag}}</span></big>, Pcs per box: <big><span style="color:red">{{$line->pcs_per_box}}</span></big></b></p>
								
									<p><span style='color:red'>* Because brand is Intimissimi, you don't have to update Pc per polybag and box for second quality * </span></p>
								@else
									<p>{{$line->material}} -> <b>Pcs per polybag(2Q): <big><span style="color:red">{{$line->pcs_per_polybag_2}}</span></big>, Pcs per box(2Q): <big><span style="color:red">{{$line->pcs_per_box_2}}</span></big></b></p>
								@endif

							@endforeach

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
								{!! Form::submit('Confirm to update all', ['class' => 'btn btn-success btn center-block']) !!}
							</div>

							@include('errors.list')

							{!! Form::close() !!}

						@else
							<p><big><span style="color:red">Missing information about second qualty, because that unable to update all materials at once. Try first to update 2Q information.</span></big></p>

							@include('errors.list')

							{!! Form::close() !!}		
						@endif
					

				
				<br>
				
			</div>
		</div>
	</div>
</div>
@endsection
