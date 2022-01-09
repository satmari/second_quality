@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading h-b">Magacin Shipment Table 
                    @if (isset($type))
                        {{--<i><small>{{ $type }}</small></i>--}}
                    @endif   
                    &nbsp&nbsp&nbsp

                    <a href="{{url('/magacin_shipment')}}" class="btn btn-default btn-xs @if ($type == '(OPEN)') active @endif">OPEN</a>
                    <a href="{{url('/magacin_shipment_closed')}}" class="btn btn-default btn-xs @if ($type == '(CLOSED)') active @endif">CLOSED</a>

                    <a href="{{url('/add_new_shipment')}}" class="btn btn-success btn-xs ">Create new shipment</a>
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
                            <th data-sortable="true">Shipment</th>
                            <th data-sortable="true">Approval</th>
                            <th data-sortable="true">Boxes</th>
                            <th data-sortable="true">Garments</th>
                            <th data-sortable="true">Shipment Status</th>
                            <th data-sortable="true">Updated at</th>
                            
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        <tr>
                            {{--<td>{{ $line->id }}</td>--}}
                            <td>{{ $line->shipment }}</td>
                            <td>{{ $line->approval }}</td>
                            <td>{{ $line->no_box }}</td>
                            <td>{{ $line->no_garments }}</td>
                            <td>{{ $line->shipment_status }}</td>
                            
                            <td>{{ $line->updated_at }}</td>

                            <td>
                                {!! Form::open(['method'=>'POST', 'url'=>'/view_boxes_in_shipment' ]) !!}
                                    {!! Form::hidden('shipment', $line->shipment, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('approval', $line->approval, ['class' => 'form-control']) !!}

                                    {!! Form::submit('Box - Shipment', ['class' => 'btn btn-info btn-xs center-block ']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(['method'=>'POST', 'url'=>'/view_bag_boxes_in_shipment' ]) !!}
                                    {!! Form::hidden('shipment', $line->shipment, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('approval', $line->approval, ['class' => 'form-control']) !!}

                                    {!! Form::submit('Bag - Box - Shipment', ['class' => 'btn btn-info btn-xs center-block ']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                            </td>
                             <td>
                                {!! Form::open(['method'=>'POST', 'url'=>'/print_export_shipment' ]) !!}
                                    {!! Form::hidden('shipment', $line->shipment, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('approval', $line->approval, ['class' => 'form-control']) !!}

                                    {!! Form::submit('Print final box labels', ['class' => 'btn btn-warning btn-xs center-block']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(['method'=>'POST', 'url'=>'/select_box_to_shipment' ]) !!}
                                    {!! Form::hidden('shipment', $line->shipment, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('approval', $line->approval, ['class' => 'form-control']) !!}
                                    @if ($type == '(OPEN)') 
                                        {!! Form::submit('Select box to shipment', ['class' => 'btn btn-success btn-xs center-block ']) !!}
                                    @else
                                        {!! Form::submit('Select box to shipment', ['class' => 'btn btn-success btn-xs center-block disabled']) !!}
                                    @endif
                                    @include('errors.list')
                                {!! Form::close() !!}
                            </td>
                             <td>
                                {!! Form::open(['method'=>'POST', 'url'=>'/add_box_to_shipment' ]) !!}
                                    {!! Form::hidden('shipment', $line->shipment, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('approval', $line->approval, ['class' => 'form-control']) !!}
                                    @if ($type == '(OPEN)') 
                                        {!! Form::submit('Add box to shipment', ['class' => 'btn btn-success btn-xs center-block ']) !!}
                                    @else
                                        {!! Form::submit('Add box to shipment', ['class' => 'btn btn-success btn-xs center-block disabled']) !!}
                                    @endif
                                    @include('errors.list')
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(['method'=>'POST', 'url'=>'/close_shipment' ]) !!}
                                    {!! Form::hidden('id', $line->id, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('shipment', $line->shipment, ['class' => 'form-control']) !!}
                                    @if ($type == '(OPEN)') 
                                        {!! Form::submit('Close shipment', ['class' => 'btn btn-danger btn-xs center-block ']) !!}
                                    @else
                                        {!! Form::submit('Close shipment', ['class' => 'btn btn-danger btn-xs center-block disabled']) !!}
                                    @endif
                                    @include('errors.list')
                                {!! Form::close() !!}
                            </td>
                                
                        </tr>
                    
                    @endforeach
                    </tbody>


				<!-- <hr> -->
					
			</div>
		</div>
	</div>
</div>

@endsection