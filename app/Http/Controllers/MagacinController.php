<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\QueryException as QueryException;
use App\Exceptions\Handler;

use Illuminate\Http\Request;
//use Gbrock\Table\Facades\Table;
use Illuminate\Support\Facades\Redirect;

use App\second_quality_log;
use DB;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;

use Session;
use Validator;

class MagacinController extends Controller {

	public function index()
	{
		//
		$user = User::find(Auth::id());

		if ($user->is('admin')) { 
		    return Redirect::to('/');
		}
		if ($user->is('magacin')) { 
		    return view('Magacin.index');
		}
		if ($user->is('modul')) { 

			return view('Module.check_leader');
		}
		// return view('Request.index');
		return Redirect::to('/');
	}

	public function receive_bag_function() 
	{
		//
		return view('Magacin.enter_module');
	}

	public function enter_module(Request $request)
	{	
		$this->validate($request, ['module'=>'required']);
		$forminput = $request->all(); 

		$module = $forminput['module'];

		$find_by_module = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_logs WHERE status = 'NOT RECEIVED' AND module = '".$module."' "));
		$data = $find_by_module;
		// dd($serch_by_module);

		if (!isset($find_by_module[0]->module)) {
			$msg = 'There is no bag from this module!';
			return view('Magacin.error',compact('msg'));
		} else {
			$module = $find_by_module[0]->module;
			// $leader = $find_by_module[0]->line_leader;
		}

		return view('Magacin.recive_bag_by_module', compact('data', 'module'));
	}

	public function receive_bag_qty($id) 
	{
		//
		$qty = DB::connection('sqlsrv')->select(DB::raw("SELECT module_qty FROM second_quality_logs WHERE id = '".$id."' "));
		$module_qty = $qty[0]->module_qty;
		// dd($module_qty);

		return view('Magacin.receive_bag_qty',compact('id', 'module_qty'));
	}

	public function receive_bag(Request $request)
	{
		//
		$this->validate($request, ['received_qty'=>'required']);
		$forminput = $request->all(); 

		$id = $forminput['id'];
		$received_qty = $forminput['received_qty'];
		// dd($received_qty);

		// second_quality_log
		// try {
			
			$table = second_quality_log::findOrFail($id);

			$table->receive_qty = $received_qty;	
			$table->status = 'RECEIVED';
			/*
			if ($received_qty = 0) {
				$table->status = 'NOT RECEIVED';				
			} else {
				$table->status = 'RECEIVED';
			}
			*/
			$table->save();
			
		// }
		// catch (\Illuminate\Database\QueryException $e) {
		// 	$msg = "Problem to save in second_quality_log";
		// 	return view('Magacin.error',compact('msg'));
		// }

		// $smsg = "Uspesno ste snimili u bazu";
		// return view('Module.check_leader', compact('smsg'));
		// return Redirect::to('/magacin');

		$module = $table->module;
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_logs WHERE status = 'NOT RECEIVED' AND module = '".$module."' "));

		return view('Magacin.recive_bag_by_module', compact('data', 'module'));
	}
}