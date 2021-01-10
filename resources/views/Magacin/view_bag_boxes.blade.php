@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
                <div class="panel-heading h-c">Bag - Box Table &nbsp&nbsp&nbsp

                    {{-- 
                    {!! Form::open(['method'=>'POST', 'url'=>'/add_box_to_shipment' , 'class'=>'form-inline' ]) !!}
                        {!! Form::hidden('shipment', $shipment, ['class' => 'form-inline']) !!}
                        {!! Form::hidden('approval', $approval, ['class' => 'form-inline']) !!}

                        {!! Form::submit('Add box to shipment', ['class' => 'form-inline btn btn-success btn-xs ']) !!}
                        @include('errors.list')
                    {!! Form::close() !!}
                    --}}
                    <a href="{{url('/magacin_box')}}" class="btn btn-default btn-xs ">Back</a>

                </div>
                
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
                            <th data-sortable="true">Bag</th>
                            <th data-sortable="true">SKU</th>
                            <th data-sortable="true">SKU 2</th>
                            <th data-sortable="true">SAP SKU</th>

                            <th data-sortable="true">Brand</th>
                            <th data-sortable="true">Pro</th>
                            <th data-sortable="true">Approval</th>
                            <th data-sortable="true">Line</th>
                            <th data-sortable="true">Type</th>
                            <th data-sortable="true">Bag Qty</th>
                            <th data-sortable="true"><b><span style="color:red">Bag in Box Qty</span></b></th>
                            <th data-sortable="true">Bag status</th>

                            <th data-sortable="true">Box</th>
                            <th data-sortable="true">Box Qty</th>
                            <th data-sortable="true">Standard Qty</th>
                            <th data-sortable="true">Box Status</th>
                            <th data-sortable="true">Shipment</th>
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        <tr>
                            {{--<td>{{ $line->id }}</td>--}}
                            <td>{{ $line->bag }}</td>
                            <td>{{ $line->sap_sku }}</td>
                            <td>{{ $line->sap_sku_2 }}</td>
                            <td>{{ $line->sap_sap_sku_2 }}</td>

                            <td>{{ $line->brand }}</td>
                            <td>{{ $line->pro }}</td>
                            <td>{{ $line->approval }}</td>
                            <td>{{ $line->line }}</td>
                            <td>{{ $line->bag_type }}</td>
                            <td>{{ $line->qty_2 }}</td>
                            <td><b><span style="color:red">{{ $line->link_qty }}</span></b></td>
                            <td>{{ $line->status }}</td>

                            <td>{{ $line->box }}</td>
                            <td>{{ $line->box_qty }}</td>
                            <td>{{ $line->box_qty_standard }}</td>
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