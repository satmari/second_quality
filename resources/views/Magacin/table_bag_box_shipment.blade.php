@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading h -q">Bag - Box - Shipment Table </div>
				
				<div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class="table table-striped table-bordered" id="sort" 
                data-show-export="true"
                data-export-types="['excel','csv','txt']"
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
                            <th data-sortable="true">Bag</th>
                            <th data-sortable="true">SKU</th>
                            <th data-sortable="true">Brand</th>

                            <th data-sortable="true">PRO</th>
                            <th data-sortable="true">Approval</th>
                            <th data-sortable="true">Line</th>

                            <th data-sortable="true">Bag Status</th>
                            <th data-sortable="true">Bag qty in Box</th>

                            <th data-sortable="true">Box</th>
                            <th data-sortable="true">SKU2</th>
                            <th data-sortable="true">Box Status</th>
                            
                            <th data-sortable="true">Shipment</th>
                            <th data-sortable="true">Shipment Status</th>
                            
                            <th data-sortable="true">Updated at</th>
                            
                            
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        <tr>
                            {{--<td>{{ $line->id }}</td>--}}
                            <td>{{ $line->bag }}</td>
                            <td><pre>{{ $line->sap_sku }}</pre></td>
                            <td>{{ $line->brand }}</td>
                            
                            <td>{{ $line->pro }}</td>
                            <td>{{ $line->approval }}</td>
                            <td>{{ $line->line }}</td>

                            <td>{{ $line->status }}</td>
                            <td>{{ $line->link_qty }}</td>
                            
                            <td>{{ $line->box }}</td>
                            <td><pre>{{ $line->sap_sku_2  }}</pre></td>
                            <td>{{ $line->box_status }}</td>
                            
                            <td>{{ $line->shipment }}</td>
                            <td>{{ $line->shipment_status }}</td>

                            <td>{{ $line->updated_at }}</td>
                                
                        </tr>
                    
                    @endforeach
                    </tbody>


				<!-- <hr> -->
					
			</div>
		</div>
	</div>
</div>

@endsection