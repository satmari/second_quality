@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading h-b2">Export and print final box labels &nbsp&nbsp&nbsp

                    <a href="{{url('/magacin_shipment')}}" class="btn btn-default btn-xs">BACK</a>
                </div>
				<i>It is temporarly, in future it will be printed from button in shipment table, without export and import excel file </i>
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
                            <th data-sortable="true">BOX BO</th>
                            <th data-sortable="true">Print Item Code</th>
                            <th data-sortable="true">COLOR Description II QUALITY</th>
                            <th data-sortable="true">II choice  Size</th>
                            <th data-sortable="true">Barcode</th>
                            <th data-sortable="true">Type</th>
                            <th data-sortable="true">Box qty</th>
                            <th>b3</th>
                            <!-- <th></th> -->
                           <!--  <th data-sortable="true">Approval</th>
                            <th data-sortable="true">Box status</th>
                            <th data-sortable="true">Box standard qty</th>
                            <th data-sortable="true">Box shipment status</th>
                            <th data-sortable="true">Shipment</th>
                            <th data-sortable="true">Shipment status</th> -->

                            
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        <tr>
                            {{--<td>{{ $line->id }}</td>--}}
                            <td>{{ $line->box }}</td>
                            <td>{{ $line->print_style }}</td>
                            <td>{{ $line->col_desc_2 }}</td>
                            <td>{{ $line->size_2 }}</td>
                            <td>{{ $line->barcode }}</td>
                            <td>{{ $line->type }}</td>
                            <td>{{ $line->box_qty }}</td>
                            <td>{{ substr($line->barcode, -3) }}</td>
                            <!-- <td></td> -->
                            {{--<td> $line->approval </td>--}}
                            {{--<td> $line->box_status </td>--}}
                            {{--<td> $line->box_qty_standard </td>--}}
                            {{--<td> $line->shipment_status </td>--}}
                            {{--<td> $line->shipment </td>--}}
                            {{--<td> $line->shipment_status </td>--}}

                                
                        </tr>
                    
                    @endforeach
                    </tbody>


				<!-- <hr> -->
					
			</div>
		</div>
	</div>
</div>

@endsection