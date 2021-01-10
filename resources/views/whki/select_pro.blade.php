@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-2 col-md-offset-5">
            <div class="panel panel-default">
				<div class="panel-heading">4. Choose PRO/KOMESA</div>
				<br>
					@if(isset($msg))
						<div class="alert alert-danger" role="alert">
						  {{ $msg }}
						</div>
					@endif
					
					{!! Form::open(['method'=>'POST', 'url'=>'/select_pro_k']) !!}
						<input name="_token" type="hidden" value="{!! csrf_token() !!}" />

						{!! Form::hidden('line', $line, ['class' => 'form-control']) !!}
						{!! Form::hidden('line_shift', $line_shift, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag', $bag, ['class' => 'form-control']) !!}
						{!! Form::hidden('bag_type', $bag_type , ['class' => 'form-control']) !!}

						<!-- <div class="panel-body">
						<p>PRO/Komesa: <span style="color:red;">*</span></p>
							<select name="pro" class="chosen">
								<option value="" selected></option>
							@foreach ($pros as $row)
								{{ $row->pro }}
								<option value="{{ $row->pro }}" 
									
									>{{ $row->pro }}
								</option>
							@endforeach
							</select>
						</div> -->

						<div class="panel-body">
							<p>PRO/Komesa:</p>
							{!! Form::text('proo', null, ['id' => 'pok', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>


						<br>
						{!! Form::submit('Continue', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
					
					<!-- <hr>					 -->
					<br>
					<p><big><b>Info</b></big></p>
					<p>Line: {{ $line }}, Shift: {{ $line_shift }}</p>
					<p>Bag: {{ $bag }}</p>
					<p>Bag type: {{ $bag_type }}</p>
					<br>
				<!-- <hr> -->
				
			</div>
		</div>
	</div>
</div>

@endsection