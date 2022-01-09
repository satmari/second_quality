@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading h-c">Audit Table
                 <a href="{{url('/scan_bag')}}" class="btn btn-warning btn-xs ">Scan and check Bag</a>
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
                            <th data-sortable="true">Bag Type</th>
                            <th data-sortable="true">Line</th>
                            <th data-sortable="true">Shift</th>
                            <th data-sortable="true">PRO</th>
                            <th data-sortable="true">Approval</th>
                            <th data-sortable="true">Sku</th>
                            <th data-sortable="true">Status</th>
                            <th data-sortable="true">Original Qty</th>
                            <th data-sortable="true">Audit Qty</th>
                            <th data-sortable="true">2nd Q</th>
                            <th data-sortable="true">1nd Q (APP)</th>
                            <th data-sortable="true">1nd Q (REP)</th>
                            <th data-sortable="true">1nd Q (CLE)</th>
                            <th data-sortable="true">Balance</th>
                            <th data-sortable="true">Coment</th>
                            <th data-sortable="true">Barcode type</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            
                            
                        </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    @foreach ($data as $line)

                        <tr>
                            {{--<td>{{ $line->id }}</td>--}}
                            <td>{{ $line->bag }}</td>
                            <td>{{ $line->bag_type }}</td>
                            <td>{{ $line->line }}</td>
                            <td>{{ $line->shift }}</td>
                            <td>{{ $line->pro }}</td>
                            <td>{{ $line->approval }}</td>
                            <!-- <td>{{ str_replace(' ', '&nbsp;' , $line->sap_sku ) }}</td> -->
                            <td><pre>{{ $line->sap_sku }}</pre></td>
                            <td>{{ $line->status }}</td>
                            <td>{{ $line->qty }}</td>
                            <td>{{ $line->qty_audit }}</td>
                            <td>{{ $line->qty_2 }}</td>
                            <td>{{ $line->qty_1_approved }}</td>
                            <td>{{ $line->qty_1_repaired }}</td>
                            <td>{{ $line->qty_1_cleaned }}</td>
                            <td>{{ $line->balance }}</td>
                            <td>{{ $line->coment }}</td>
                            <td>{{ $line->barcode_type }}</td>
                            
                            <td>
                                @if ($line->status == "AUDIT_TO_DO")
                                {!! Form::open(['method'=>'POST', 'url'=>'/change_bag_po' ]) !!}
                                    
                                    {!! Form::hidden('id', $line->id, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('bag', $line->bag, ['class' => 'form-control']) !!}
                                    
                                    {!! Form::submit('Change PO', ['class' => 'btn btn-primary btn-sm center-block']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                                @else 
                                 {!! Form::open(['method'=>'POST', 'url'=>'/change_bag_po' ]) !!}
                                    
                                    {!! Form::hidden('id', $line->id, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('bag', $line->bag, ['class' => 'form-control']) !!}
                                    
                                    {!! Form::submit('Change PO', ['class' => 'btn btn-primary btn-sm center-block disabled']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}

                                @endif
                            </td>
                            <td>
                                @if ($line->status == "AUDIT_TO_DO")
                                {!! Form::open(['method'=>'POST', 'url'=>'/cancel_bag' ]) !!}
                                    
                                    {!! Form::hidden('id', $line->id, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('bag', $line->bag, ['class' => 'form-control']) !!}
                                    
                                    {!! Form::submit('Cancel', ['class' => 'btn btn-danger btn-sm center-block']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                                @else 
                                {!! Form::open(['method'=>'POST', 'url'=>'/cancel_bag' ]) !!}
                                    
                                    {!! Form::hidden('id', $line->id, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('bag', $line->bag, ['class' => 'form-control']) !!}
                                    
                                    {!! Form::submit('Cancel', ['class' => 'btn btn-danger btn-sm center-block disabled']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                                
                                @endif

                            </td>
                            <td>
                                @if ($line->status == "AUDIT_TO_DO")
                                {!! Form::open(['method'=>'POST', 'url'=>'/scan_bag_audit' ]) !!}
                                    
                                    {!! Form::hidden('bag', $line->bag, ['class' => 'form-control']) !!}
                                    
                                    {!! Form::submit('Check', ['class' => 'btn btn-info btn-sm center-block']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                                @else
                                {!! Form::open(['method'=>'POST', 'url'=>'/scan_bag_audit' ]) !!}
                                    
                                    {!! Form::hidden('bag', $line->bag, ['class' => 'form-control']) !!}
                                    
                                    {!! Form::submit('Check', ['class' => 'btn btn-info btn-sm center-block disabled']) !!}
                                    @include('errors.list')
                                {!! Form::close() !!}
                                @endif
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