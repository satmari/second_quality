@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row vertical-center-row">
		<div class="text-center">
			<div class="panel panel-default">
				<div class="panel-heading">Reseive bag from module <b><big>{{ $module }}</big></b> </div>
				
				<div class="input-group"> <span class="input-group-addon">Filter</span>
				    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class="table table-striped table-bordered" id="sort" 
                data-show-export="true"
                data-export-types="['excel']"
                >
                <!--
                data-show-toggle="true"
                data-show-columns="true" 
                data-show-export="true"
                data-export-types="['excel']"
                data-search="true"
                data-show-refresh="true"
                data-show-toggle="true"
                data-query-params="queryParams" 
                data-pagination="true"
                data-height="300"
                data-show-columns="true" 
                data-export-options='{
                         "fileName": "preparation_app", 
                         "worksheetName": "test1",         
                         "jspdf": {                  
                           "autotable": {
                             "styles": { "rowHeight": 20, "fontSize": 10 },
                             "headerStyles": { "fillColor": 255, "textColor": 0 },
                             "alternateRowStyles": { "fillColor": [60, 69, 79], "textColor": 255 }
                           }
                         }
                       }'
                -->
				    <thead>
				        <tr>
				           {{-- <th>id</th> --}}
				           
				           <!-- <th>Module</th> -->
				           <!-- <th>Status</th> -->

				           <th>Date</th>
				           <th>Line Leader</th>
				           <th>Po</th>
				           <th>Style</th>
				           <th>Color</th>
				           <th>Color Desc</th>
				           <th>Bag type</th>
				           <th>Quantity by module</th>

				           <!-- <th>Created</th> -->
				           <th></th>

				        </tr>
				    </thead>
				    <tbody class="searchable">
				    
				    @foreach ($data as $d)
				    	
				        <tr>
				        	{{-- <td>{{ $d->id }}</td> 
				        	<td> {{ $d->module }}</td>
				        	<td> {{ $d->status }}</td>--}}

				        	<td> {{ $d->created_at }}</td>
				        	<td> {{ $d->line_leader }}</td>
				        	<td> {{ $d->po }}</td>
				        	<td> {{ $d->item }}</td>
				        	<td> {{ $d->color }}</td>
				        	<td> {{ $d->color_desc }}</td>
				        	<td> {{ $d->type }}</td>
				        	<td> {{ $d->module_qty }}</td>
				        	
				        	<td>
				        	@if ($d->status == "NOT DELIVERED")
				        		<a href="{{ url('/receive_bag_qty/'.$d->id) }}" class="btn btn-info btn-xs center-block" disabled>Receive bag</a>
				        	@else
				        		<a href="{{ url('/receive_bag_qty/'.$d->id) }}" class="btn btn-info btn-xs center-block" >Receive bag</a>
				        	@endif
				        	</td>

						</tr>
				    
				    @endforeach
				    </tbody>

				</table>
			</div>
		</div>
	</div>
</div>

@endsection