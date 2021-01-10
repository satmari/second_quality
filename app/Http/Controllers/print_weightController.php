<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\QueryException as QueryException;
use App\Exceptions\Handler;

use Illuminate\Http\Request;
//use Gbrock\Table\Facades\Table;
use Illuminate\Support\Facades\Redirect;

use App\print_weight;
use DB;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;

use Session;
use Validator;

class print_weightController extends Controller {

	public function index()
	{
		//
		$printer_from_ses = Session::get('printer');
		// dd($printer_from_ses);

		if (is_null($printer_from_ses)) {
			// dd('no ses');

			return view('print_weight.printer');

		} else {

			$printer = $printer_from_ses;
			// dd('ses set: '.$printer);

			return view('print_weight.print', compact('printer'));			
		}

	}

	public function printer_set(Request $request) {

		$this->validate($request, ['printer_name' => 'required']);
		$input = $request->all(); 

		$printer = $input['printer_name'];
		Session::set('printer', $printer);
		$printer = Session::get('printer');

		// dd($printer);
		return view('print_weight.print', compact('printer'));

	}

	public function diff_printer()
	{
		//
		Session::set('printer', null);
		return Redirect::to('/print_weight_label');
	}

	public function set_weigth(Request $request) {
	
		$this->validate($request, ['printer' => 'required', 'print_qty' => 'required']);
		$input = $request->all(); 
	
		$printer = $input['printer'];
		Session::set('printer', $printer);
		$print_qty =  round((float)$input['print_qty'],3);
		// dd($print_qty);

		$uom = 'KG';

		$table = new print_weight;
		$table->print_qty = $print_qty;
		$table->uom = $uom;
		$table->printer = $printer;
								
		$table->save();

		return Redirect::to('/print_weight_label');

	}
	

}
