@extends('app')

@section('content')
<div class="container container-table">
	<div class="row">
		<div class="text-center col-md-8 col-md-offset-2">
			
				
				<h3 style="color:red;"></h3>
				<p style="color:red;"></p>

				<div class="panel panel-default">
					<div class="panel-heading">Import table to print</div>
					
						{!! Form::open(['files'=>'True', 'method'=>'POST', 'action'=>['second_q@import_post_second_q'] ]) !!}
							<br>
							<div class="panel-body">
								{!! Form::file('file', ['class' => 'center-block']) !!}
							</div>
							<br>
							<div class="panel-body">
								{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
							</div>
							<br>
							
						{!! Form::close() !!}
				</div>		
				
		</div>
	</div>
</div>
	

@endsection