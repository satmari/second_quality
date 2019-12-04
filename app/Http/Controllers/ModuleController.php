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

class ModuleController extends Controller {

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

	public function check_leader(Request $request)
	{	
		$this->validate($request, ['pin'=>'required|min:4|max:5']);
		$forminput = $request->all(); 

		$pin = $forminput['pin'];

		$inteosleaders = DB::connection('sqlsrv2')->select(DB::raw("SELECT Name FROM BdkCLZG.dbo.WEA_PersData WHERE (Func = 23) and (FlgAct = 1) and (PinCode = ".$pin.")"));

		if (empty($inteosleaders)) {
			$msg = 'LineLeader with this PIN not exist';
		    return view('Module.error',compact('msg'));
		
		} else {
			foreach ($inteosleaders as $row) {
    			$leader = $row->Name;
    			Session::set('leader', $leader);
    		}

    		if (Auth::check())
			{
			    $userId = Auth::user()->id;
			    $module = Auth::user()->name;
			} else {
				$msg = 'Modul is not autenticated';
				return view('Module.error',compact('msg'));
			}
    	}

    	$leader = Session::get('leader');
    	// dd($leader);

    	// return view('Module.choose_order', compact('leader'));
    	return view('Module.choose_type', compact('leader'));
    }

    public function choose_type($type, Request $request)
    {
    	// $this->validate($request, ['type'=>'required']);
		// $forminput = $request->all();
		// $type = $forminput['type'];
		// dd($type);

		if ($type = 'RED') {
			// $type = 'STAND BY';
			$type = 'RED';
		}

		if ($type = 'YELLOW') {
			// $type = 'SEWING PROBLEM';
			$type = 'YELLOW';
		}

		if ($type = 'BLUE') {
			// $type = 'MATERIAL PROBLEM';
			$type = 'BLUE';
		}

		Session::set('type', $type);

		$leader = Session::get('leader');
		// $po = Session::get('po');
		// $size = Session::get('size');
		// $type = Session::get('type');

		// dd('Leader: '.$leader.' ,po: '.$po.' ,size: '.$size.' , type: '.$type);
		// return view('Module.choose_type', compact('leader'));
		return view('Module.choose_order', compact('leader'));
    }

    public function choose_order(Request $request)
    {
    	// $this->validate($request, ['po'=>'required|min:5']);
		// $forminput = $request->all();
    	$leader = Session::get('leader');
    	$type = Session::get('type');

		$validator = Validator::make($request->all(), [
            'po' => 'required|min:5|max:5',
            'size' => 'required|min:1|max:5',
            'qty' => 'required|min:1|max:100'
        ]);

        if ($validator->fails()) {
        	$msg = 'Niste popunili sva polja';
        	return view('Module.choose_order', compact('leader','msg'));
        }

		if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $forminput = $request->all();
		$po = $forminput['po'];
		$size = $forminput['size'];
		$qty = $forminput['qty'];
		// dd('po: '.$po.' size: '.$size.' qty: '.$qty);
		// Session::set('po', $po);
		// Session::set('size', $size);

		$released = DB::connection('sqlsrv3')->select(DB::raw("SELECT 
		      po.[Status],
		      po.[No_] as no,
		      /*po.[Description], */
		      po.[Source No_] as item,
		      /*
		      po.[Shortcut Dimension 2 Code],
		      po.[Cutting Prod_ Line] as flash,
		      po.[Flash Order],
		      po.[Extra Flash],
		      po.[WMS Status],
		      po.[PfsProduction Line],
		      po.[Batch No_],
		      po.[Barcode No_],
		      po.[Docket No],
		      */
		      pol.[PfsVertical Component] as color,
		      pol.[PfsHorizontal Component] as size,
		      
		      comp.[Description] as color_desc
		      
			  FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] as po
				JOIN [Gordon_LIVE].[dbo].[GORDON\$Prod_ Order Line] as pol ON po.[No_] = pol.[Prod_ Order No_]
			    JOIN [Gordon_LIVE].[dbo].[GORDON\$PfsVert Component] as comp ON pol.[PfsVert Component Group] = comp.[Component Group Code] AND pol.[PfsVertical Component] = comp.[Code]
			  WHERE po.[Status] = '3' AND pol.[Prod_ Order No_] like '%".$po."' AND pol.[PfsHorizontal Component] = '".$size."'

		"));		
		// dd($released[0]->no);

		if (!isset($released[0]->no)) {
			$msg = 'Komesa sa ovom velicinom ne postoji ili je zatvorena!';
			return view('Module.error',compact('msg'));
		}

		$po = $po;
		$size = $size;
		$qty = $qty;
		$leader = Session::get('leader');
		$module = Auth::user()->name;
		$item = $released[0]->item;
		$color = $released[0]->color;
		$color_desc = $released[0]->color_desc;
		$type = $type;
		$status = "NOT RECEIVED";
		
		// second_quality_log
		// try {
			$table = new second_quality_log;

			$table->module = $module;
			$table->line_leader = $leader;
			$table->type = $type;
			$table->po = $po;
			$table->size = $size;
			$table->item = $item;
			$table->color = $color;
			$table->color_desc = $color_desc;
			$table->module_qty = $qty;
			$table->receive_qty;			
			$table->status = $status;

			$table->save();
			
		// }
		// catch (\Illuminate\Database\QueryException $e) {
		// 	$msg = "Problem to save in second_quality_log";
		// 	return view('Module.error',compact('msg'));
		// }

		$smsg = "Uspesno ste snimili u bazu";
		// return view('Module.check_leader', compact('smsg'));
		return Redirect::to('/');


	}

    

}
