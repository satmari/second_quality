@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading h -q">Box Table </div>
				
				<div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class="table table-striped table-bordered" id="sort" 
                data-show-export="true"
                data-export-types="['excel']"
                >
                <!--
                
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
                            <!-- <th data-sortable="true">Id</th> -->
                            <th data-sortable="true">Box</th>
                            <th data-sortable="true">Stis code</th>
                            <th data-sortable="true">Approval</th>
                            
                            <th data-sortable="true">Box Location</th>
                            <th data-sortable="true">Standard Qty</th>
                            <th data-sortable="true">Box Qty</th>
                            <th data-sortable="true">Updated at</th>
                            <th data-sortable="true">Box Status</th>
                            <th data-sortable="true">Shipment</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        <tr>
                            {{--<td>{{ $line->id }}</td>--}}
                            <td>{{ $line->box }}</td>
                            <td>{{ $line->style_2 }}</td>
                            <td>{{ $line->approval }}</td>
                            
                            <td>{{ $line->box_location }}</td>
                            <td>{{ $line->box_qty_standard }}</td>
                            <td>{{ $line->box_qty }}</td>
                            <td>{{ $line->updated_at }}</td>
                            <td>{{ $line->box_status }}</td>
                            <td>{{ $line->shipment }}</td>
                                
                        </tr>
                    
                    @endforeach
                    </tbody>


				<!-- <hr> -->
					
			</div>
		</div>
	</div>
</div>

@endsection