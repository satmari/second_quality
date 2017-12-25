@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Declare second quality garmnet</div>			
				<br>				
				{!! Form::open(['method'=>'POST', 'url'=>'/check_leader']) !!}
								
				<div class="panel-body">
					<p>LineLeader PIN code (Inteos)</p>
					{!! Form::number('pin', null, ['id' => 'pin', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success center-block']) !!}
				</div>

				@include('errors.list')
				
				{!! Form::token() !!}
				{!! Form::close() !!}

				{{--
				<hr>
				<div class="panel-body">
					<a href="{{url('/')}}" class="btn btn-default center-block">Back</a>
				</div>
				--}}
			
			</div>
			@if(isset($msg))
		        <ul class='alert alert-danger'>
					<li>{{ $msg }}</li>
				</ul>
			@endif
			@if(isset($smsg))
		        <ul class='alert alert-success'>
					<li>{{ $smsg }}</li>
				</ul>
			@endif
		</div>
		
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">

				<table class="table" style="font-size: large">
					<tr>
						<td>Informacije:</td>
					</tr>
					<tr>
						<td><span style="color:red"><b>Sve probleme obavezno prijaviti IT sektoru.</b></span></td>
					</tr>
					<tr>
						<td><span style="color:green"><b>Zatvarajte tab-ove</b></span></td>
					</tr>
					<tr>
						<td><span style="color:darkorchid">Da li imate predlog za pozadinsku sliku aplikacije?</span></td>
					</tr>
				</table>
							
			</div>
		</div>
		
	</div>
</div>
@endsection