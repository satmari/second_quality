@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading h -q">Re-check Table by SKU  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Last refresh: {{$last_refresh}}</i></div>
				
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
                            
                            
                            <th data-sortable="true">SKU</th>
                            <th data-sortable="true">SAP QTY</th>
                            <th data-sortable="true">App QTY</th>
                            <th data-sortable="true">Status</th>
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        
                        <tr>
                            
                            <td>{{ $line->sku }}</td>
                            <td>{{ $line->sap_qty }}</td>
                            <td>{{ $line->app_qty }}</td>
                            @if ($line->sap_qty == $line->app_qty)
                            <td>MATCH</td>
                            @elseif ($line->sap_qty == 0)
                            <td>NOT IN SAP</td>
                            @elseif ($line->app_qty == 0)
                            <td>NOT IN APP</td>
                            @else
                            <td>DIFFERENCE</td>
                            
                                
                        </tr>
                        @endif
                    
                    @endforeach
                    </tbody>


				<!-- <hr> -->
					
			</div>
		</div>
	</div>
</div>

@endsection