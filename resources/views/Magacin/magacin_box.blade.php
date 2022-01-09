@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading h-c">Magacin Box Table
                    @if (isset($type))
                        {{--<i><small>{{ $type }}</small></i>--}}
                    @endif   
                    &nbsp&nbsp&nbsp

                    <a href="{{url('/magacin_box')}}" class="btn btn-default btn-xs @if ($type == '(FILLING)') active @endif">FILLING</a>
                    <a href="{{url('/magacin_box_closed')}}" class="btn btn-default btn-xs @if ($type == '(FULL or CLOSED)') active @endif">FULL or CLOSED</a>
                    <a href="{{url('/magacin_box_on_shipment')}}" class="btn btn-default btn-xs @if ($type == '(ON_SHIPMENT)') active @endif">ON_SHIPMENT</a>
                    <a href="{{url('/magacin_box_shipped')}}" class="btn btn-default btn-xs @if ($type == '(SHIPPED)') active @endif">SHIPPED</a>
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
                            <th data-sortable="true">Box</th>
                            <th data-sortable="true">SKU 2</th>
                            <th data-sortable="true">Approval</th>
                            <th data-sortable="true">Box Status</th>
                            <th data-sortable="true">Box Location</th>
                            <th data-sortable="true">Standard Qty</th>
                            <th data-sortable="true">Qty in box</th>
                            <th data-sortable="true">Updated at</th>
                            <th data-sortable="true">Shipment</th>
                            <th></th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        <tr>
                            {{--<td>{{ $line->id }}</td>--}}
                            <td>{{ $line->box }}</td>
                             {{--<td>{{ $line->style_2 }} {{ $line->color_2 }} {{ $line->size_2 }}</td>--}}
                            <td><pre>{{ $line->sap_sku_2 }}</pre></td>
                            <td>{{ $line->approval }}</td>
                            <td>{{ $line->box_status }}</td>
                            <td>{{ $line->box_location }}</td>
                            <td>{{ $line->box_qty_standard }}</td>
                            <td>{{ $line->box_qty }}</td>
                            <td>{{ $line->updated_at }}</td>
                            <td>{{ $line->shipment }}</td>

                            <td>
                                {!! Form::open(['method'=>'POST', 'url'=>'/view_bag_boxes' ]) !!}
                                    {!! Form::hidden('box', $line->box, ['class' => 'form-control']) !!}
                                    
                                    {!! Form::submit('Bag - Box', ['class' => 'btn btn-info btn-xs center-block ']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                            </td>

                            @if ($type == '(FILLING)')
                                <td>
                                    {!! Form::open(['method'=>'POST', 'url'=>'/close_box' ]) !!}
                                        {!! Form::hidden('box_id', $line->id, ['class' => 'form-control']) !!}

                                        {!! Form::submit('Close box', ['class' => 'btn btn-danger btn-xs center-block']) !!}
                                        @include('errors.list')
                                    {!! Form::close() !!}
                                </td>
                            @else
                                <td>
                                    {!! Form::open(['method'=>'POST', 'url'=>'/close_box' ]) !!}
                                        {!! Form::hidden('box_id', $line->id, ['class' => 'form-control']) !!}

                                        {!! Form::submit('Close box', ['class' => 'btn btn-danger btn-xs center-block disabled']) !!}
                                        @include('errors.list')
                                    {!! Form::close() !!}
                                </td>
                            @endif

                        </tr>
                    
                    @endforeach
                    </tbody>


				<!-- <hr> -->
					
			</div>
		</div>
	</div>
</div>

@endsection