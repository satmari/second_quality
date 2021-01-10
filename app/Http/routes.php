<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', 'HomeController@index');

// Module
// Route::get('/module', 'ModuleController@index');


// Magacin
Route::get('/magacin_index', 'MagacinController@index');
Route::get('/magacin', 'MagacinController@magacin_bag');
Route::get('/magacin_bag_wh_stock', 'MagacinController@magacin_bag_wh_stock');
Route::get('/magacin_bag_audit_checked', 'MagacinController@magacin_bag_audit_checked');
Route::get('/magacin_bag_in_box', 'MagacinController@magacin_bag_in_box');
Route::get('/scan_bag_magacin', 'MagacinController@scan_bag_magacin');
Route::post('/scan_bag_magacin', 'MagacinController@scan_bag_magacin');
Route::post('/scan_bag_location', 'MagacinController@scan_bag_location');
Route::post('/scan_confirm_location', 'MagacinController@scan_confirm_location');

Route::get('/table', 'MagacinController@table');
Route::get('/table_box', 'MagacinController@table_box');
Route::get('/table_shipment', 'MagacinController@table_shipment');

Route::get('/scan_multiple', 'MagacinController@scan_multiple');
Route::post('/scan_bag_multiple_location', 'MagacinController@scan_bag_multiple_location');
Route::post('/scan_bag_multiple_location_scan', 'MagacinController@scan_bag_multiple_location_scan');
Route::post('/scan_bag_multiple_location_post', 'MagacinController@scan_bag_multiple_location_post');

Route::get('/magacin_box', 'MagacinController@magacin_box');
Route::get('/magacin_box_closed', 'MagacinController@magacin_box_closed');
Route::get('/magacin_box_on_shipment', 'MagacinController@magacin_box_on_shipment');
Route::get('/magacin_box_shipped', 'MagacinController@magacin_box_shipped');
Route::get('/scan_bag_to_box', 'MagacinController@scan_bag_to_box');

Route::post('/add_bag_to_box', 'MagacinController@add_bag_to_box');
Route::post('/one_create_box_post', 'MagacinController@one_create_box_post');
Route::post('/one_existing_box_post', 'MagacinController@one_existing_box_post');
Route::post('/more_create_box_post', 'MagacinController@more_create_box_post');
Route::post('/more_existing_box_post', 'MagacinController@more_existing_box_post');
Route::post('/view_bag_boxes', 'MagacinController@view_bag_boxes');
Route::post('/view_bag_boxes_in_shipment', 'MagacinController@view_bag_boxes_in_shipment');

Route::post('/close_box', 'MagacinController@close_box');

Route::get('/magacin_shipment', 'MagacinController@magacin_shipment');
Route::get('/magacin_shipment_closed', 'MagacinController@magacin_shipment_closed');
Route::get('/add_new_shipment', 'MagacinController@add_new_shipment');
Route::post('add_new_shipment_post', 'MagacinController@add_new_shipment_post');
Route::post('view_boxes_in_shipment', 'MagacinController@view_boxes_in_shipment');
Route::post('view_export_shipment', 'MagacinController@view_export_shipment');

Route::post('add_box_to_shipment', 'MagacinController@add_box_to_shipment');
Route::post('add_box_to_shipment_post', 'MagacinController@add_box_to_shipment_post');
Route::post('close_shipment', 'MagacinController@close_shipment');
Route::post('close_shipment_confirm', 'MagacinController@close_shipment_confirm');
Route::post('close_shipment_confirm_delete', 'MagacinController@close_shipment_confirm_delete');

Route::post('/edit_box2', 'MagacinController@edit_box2');
Route::post('update_box/{id}', 'MagacinController@update_box');

// Audit
Route::get('/audit', 'AuditController@index');
Route::get('/scan_bag', 'AuditController@scan_bag');
Route::post('/scan_bag_audit', 'AuditController@scan_bag_audit');
Route::post('/result_confirm', 'AuditController@result_confirm');
Route::post('/result_change_qty', 'AuditController@result_change_qty');

Route::get('/edit_bag/{id}', 'AuditController@edit_bag');

Route::post('/cancel_bag', 'AuditController@cancel_bag');
Route::post('/cancel_confirm', 'AuditController@cancel_confirm');

Route::post('/change_bag_po', 'AuditController@change_bag_po');
Route::post('/change_bag_po_confirm', 'AuditController@change_bag_po_confirm');

// WHsu
Route::get('/whsu', 'whsuController@index');
Route::get('/scan_start', 'whsuController@scan_start');
Route::post('/scan_line', 'whsuController@scan_line');
Route::post('/scan_bag', 'whsuController@scan_bag');
Route::post('/choose_bag_type', 'whsuController@choose_bag_type');
Route::post('/select_pro', 'whsuController@select_pro');
Route::post('/confirm', 'whsuController@confirm');

Route::get('/transfer_to_subotica', 'whsuController@transfer_to_subotica');
Route::post('/transfer_bag', 'whsuController@transfer_to_subotica');

Route::get('/print_bag_su', 'whsuController@print_bag_su');
Route::post('/print_bag_su_confirm', 'whsuController@print_bag_su_confirm');
Route::post('/print_bag_su_confirm_print', 'whsuController@print_bag_su_confirm_print');

// Whki
Route::get('/whki', 'whkiController@index');
Route::get('/scan_start_k', 'whkiController@scan_start');
Route::post('/scan_line_k', 'whkiController@scan_line');
Route::post('/choose_line_shift', 'whkiController@choose_line_shift');
Route::post('/scan_bag_k', 'whkiController@scan_bag');
Route::post('/choose_bag_type_k', 'whkiController@choose_bag_type');
Route::post('/select_pro_k', 'whkiController@select_pro');
Route::post('/confirm_k', 'whkiController@confirm');

Route::get('/print_bag_ki', 'whkiController@print_bag_ki');
Route::post('/print_bag_ki_confirm', 'whkiController@print_bag_ki_confirm');
Route::post('/print_bag_ki_confirm_print', 'whkiController@print_bag_ki_confirm_print');

// Print weigth
Route::get('/print_weight_label', 'print_weightController@index');
Route::post('printer_set', 'print_weightController@printer_set');
Route::get('diff_printer', 'print_weightController@diff_printer');
Route::post('set_weigth', 'print_weightController@set_weigth');

// Print secong q box
Route::get('second_q', 'second_q@index');
Route::post('import_post_second_q', 'second_q@import_post_second_q');

Route::any('getpodata', function() {
		$term = Input::get('term');

		// $data = DB::connection('sqlsrv')->table('pos')->distinct()->select('po')->where('po','LIKE', $term.'%')->where('closed_po','=','Open')->groupBy('po')->take(10)->get();
		// $data = DB::connection('sqlsrv3')->select(DB::raw("SELECT TOP 10 (RIGHT([No_],5)) as po FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] WHERE [Status] = '3' AND [No_] like '%".$term."%'"));
		$data = DB::connection('sqlsrv2')->select(DB::raw("SELECT TOP 10 [POnum] as po FROM [BdkCLZG].[dbo].[CNF_PO] WHERE (POClosed is null OR POClosed = '0') AND POnum like '%".$term."%' "));
		// var_dump($data);
			foreach ($data as $v) {
				$retun_array[] = array('value' => $v->po);
			}
		return Response::json($retun_array);
});
Route::any('getpodatak', function() {
		$term = Input::get('term');

		// $data = DB::connection('sqlsrv')->table('pos')->distinct()->select('po')->where('po','LIKE', $term.'%')->where('closed_po','=','Open')->groupBy('po')->take(10)->get();
		// $data = DB::connection('sqlsrv3')->select(DB::raw("SELECT TOP 10 (RIGHT([No_],5)) as po FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] WHERE [Status] = '3' AND [No_] like '%".$term."%'"));
		$data = DB::connection('sqlsrv2')->select(DB::raw("SELECT TOP 10 [POnum] as po FROM [172.27.161.221\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO] WHERE (POClosed is null OR POClosed = '0') AND POnum like '%".$term."%' "));
		// var_dump($data);
			foreach ($data as $v) {
				$retun_array[] = array('value' => $v->po);
			}
		return Response::json($retun_array);
});
