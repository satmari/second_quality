<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\QueryException as QueryException;
use App\Exceptions\Handler;

use Illuminate\Http\Request;
//use Gbrock\Table\Facades\Table;
use Illuminate\Support\Facades\Redirect;

// use App\trans_color;
// use App\trans_item;
// use App\trans_size;
// use App\temp_print;
// use App\RequestHeader;
// use App\RequestLine;
use DB;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;

use Session;
use Validator;

class MainController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		//
		// $user = User::find(Auth::id());

		// if ($user->is('admin')) { 
		//     return Redirect::to('/');
		// }
		// if ($user->is('magacin')) { 
		//     return Redirect::to('/');
		// }
		// if ($user->is('modul')) { 
		// 	return view('Request.index'); 
		// }
		// // return view('Request.index');
		// return Redirect::to('/');
	}

}
