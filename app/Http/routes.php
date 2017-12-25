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

// Route::get('/', 'WelcomeController@index');

Route::get('/', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Module
Route::get('/module', 'ModuleController@index');
Route::post('/check_leader', 'ModuleController@check_leader');
Route::get('/choose_type/{type}', 'ModuleController@choose_type');
Route::post('/choose_order', 'ModuleController@choose_order');

// Magacin
Route::get('/magacin', 'MagacinController@index');
Route::get('/receive_bag_function', 'MagacinController@receive_bag_function');
Route::post('/enter_module', 'MagacinController@enter_module');
Route::get('/receive_bag_qty/{id}', 'MagacinController@receive_bag_qty');
Route::post('/receive_bag', 'MagacinController@receive_bag');

Route::any('getpodata', function() {
	$term = Input::get('term');

	// $data = DB::connection('sqlsrv')->table('pos')->distinct()->select('po')->where('po','LIKE', $term.'%')->where('closed_po','=','Open')->groupBy('po')->take(10)->get();
	$data = DB::connection('sqlsrv3')->select(DB::raw("SELECT TOP 10 (RIGHT([No_],5)) as po FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] WHERE [Status] = '3' AND [No_] like '%".$term."%'"));
	// var_dump($data);
	foreach ($data as $v) {
		$retun_array[] = array('value' => $v->po);
	}
return Response::json($retun_array);
});