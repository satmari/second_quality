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

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		
		Session::set('leader', NULL);
		Session::set('po', NULL);
		Session::set('size', NULL);
		Session::set('type', NULL);

		$user = User::find(Auth::id());

		if (Auth::check())	
		{
		    // $userId = Auth::user()->id;
		    $module = Auth::user()->name;
		    // var_dump($module);
		}

		if ($user->is('admin')) { 
		    // var_dump("admin");
		    return Redirect::to('/admin');
		}

		if ($user->is('magacin')) { 
			// var_dump("modul");
			return Redirect::to('/magacin');
		}
		
		if ($user->is('modul')) { 
			// var_dump("modul");
			return Redirect::to('/module');
		}
		

		return view('home');
		// return Redirect::to('/');
	}

}
