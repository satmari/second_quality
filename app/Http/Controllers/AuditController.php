<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\QueryException as QueryException;
use App\Exceptions\Handler;

use Illuminate\Http\Request;
//use Gbrock\Table\Facades\Table;
use Illuminate\Support\Facades\Redirect;

// use App\second_quality;
use App\second_quality_bag;
use DB;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;

use Session;
use Validator;

class AuditController extends Controller {

	public function index()
	{
		//
		// dd($data);
		return view('audit.index');
	}

	public function audit_table()
	{
		//
		// dd('test');
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE status = 'AUDIT_TO_DO' ORDER BY id asc"));
		// dd($data);
		return view('audit.table', compact('data'));
	}

	public function scan_bag()
	{
		//
		return view('audit.scan_bag');
	}

	public function scan_bag_audit(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag = strtoupper($input['bag']);

		//
		$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' AND status = 'AUDIT_TO_DO' "));

		if (!isset($bag_exist[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag not exist in table or status of bag is different than AUDIT_TO_DO';
			return view('audit.scan_bag', compact('msg'));
		} 

		$id = $bag_exist[0]->id;
		$pro = $bag_exist[0]->pro;
		$approval = $bag_exist[0]->approval;
		$sap_sku = $bag_exist[0]->sap_sku;
		$bag_type = $bag_exist[0]->bag_type;
		$line = $bag_exist[0]->line;

		$qty = (int)$bag_exist[0]->qty;
		$qty_audit = (int)$bag_exist[0]->qty_audit;
		$qty_2 = (int)$bag_exist[0]->qty_2;
		$qty_1_approved = (int)$bag_exist[0]->qty_1_approved;
		$qty_1_repaired = (int)$bag_exist[0]->qty_1_repaired;
		$qty_1_cleaned = (int)$bag_exist[0]->qty_1_cleaned;
		$balance = (int)$bag_exist[0]->balance;
		// dd($balance);

		if ( $qty_audit == 0 ) {
			
			$balance = $qty - $qty_2 - $qty_1_approved - $qty_1_repaired - $qty_1_cleaned;
			// dd($balance);
			$box = second_quality_bag::findOrFail($id);
			$box->balance = $balance;
			$box->save();

		} else {

			$balance = $qty_audit - $qty_2 - $qty_1_approved - $qty_1_repaired - $qty_1_cleaned;
			// dd($balance);			
			$box = second_quality_bag::findOrFail($id);
			$box->balance = $balance;
			$box->save();
		}

		// dd($balance);
		$coment = $bag_exist[0]->coment;

		return view('audit.result', compact('bag','id','pro','approval','sap_sku','bag_type','line',
		'qty','qty_audit','qty_2','qty_1_approved','qty_1_repaired','qty_1_cleaned','balance','coment'));


	}

	public function result_change_qty(Request $request) {
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		// $bag = strtoupper($input['bag']);
		$qty_audit = (int)$input['qty_audit'];
		$bag = $input['bag'];
		$id = $input['id'];
		// dd($qty_audit);

		try {	
			$box = second_quality_bag::findOrFail($id);
			$box->qty_audit = $qty_audit;
			$box->save();
			
		}
		catch (\Illuminate\Database\QueryException $e) {
			// dd('problem to save');
			$msg = 'Problem to save';
			return view('audit.scan_bag_audit', compact('msg'));
		}

		//
		$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' AND status = 'AUDIT_TO_DO' "));

		if (!isset($bag_exist[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag not exist in table or status of bag is different than AUDIT_TO_DO';
			return view('audit.scan_bag_audit', compact('msg'));
		} 

		$id = $bag_exist[0]->id;
		$pro = $bag_exist[0]->pro;
		$approval = $bag_exist[0]->approval;
		$sap_sku = $bag_exist[0]->sap_sku;
		$bag_type = $bag_exist[0]->bag_type;
		$line = $bag_exist[0]->line;

		$qty = (int)$bag_exist[0]->qty;
		$qty_audit = (int)$bag_exist[0]->qty_audit;
		$qty_2 = (int)$bag_exist[0]->qty_2;
		$qty_1_approved = (int)$bag_exist[0]->qty_1_approved;
		$qty_1_repaired = (int)$bag_exist[0]->qty_1_repaired;
		$qty_1_cleaned = (int)$bag_exist[0]->qty_1_cleaned;
		$balance = (int)$bag_exist[0]->balance;

		if ( $qty_audit == 0 ) {
			
			$balance = $qty - $qty_2 - $qty_1_approved - $qty_1_repaired - $qty_1_cleaned;
			// dd($balance);
			if ($balance < 0) {
				dd('Balance can not be less than 0 !');
			}
			$box = second_quality_bag::findOrFail($id);
			$box->balance = $balance;
			$box->save();

		} else {

			$balance = $qty_audit - $qty_2 - $qty_1_approved - $qty_1_repaired - $qty_1_cleaned;
			// dd($balance);			
			if ($balance < 0) {
				dd('Balance can not be less than 0 !');
			}
			$box = second_quality_bag::findOrFail($id);
			$box->balance = $balance;
			$box->save();
		}


		$coment = $bag_exist[0]->coment;

		$msgs1 = 'Saved successfuly';
		return view('audit.result', compact('bag','id','pro','approval','sap_sku','bag_type','line',
		'qty','qty_audit','qty_2','qty_1_approved','qty_1_repaired','qty_1_cleaned','balance','coment', 'msgs1'));

	}

	public function result_confirm(Request $request) {
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$id = $input['id'];
		$bag = $input['bag'];
		$qty_2 = (int)$input['qty_2'];
		$qty_audit = (int)$input['qty_audit'];
		$qty_1_approved = (int)$input['qty_1_approved'];
		$qty_1_repaired = (int)$input['qty_1_repaired'];
		$qty_1_cleaned = (int)$input['qty_1_cleaned'];
		// $balance = $input['balance'];
		$coment = $input['coment'];
		
		if ( $qty_audit == 0 ) {
			$balance = $qty - $qty_2 - $qty_1_approved - $qty_1_repaired - $qty_1_cleaned;
			if ($balance < 0) {
				// dd($balance);
				dd('Balance can not be less than 0 !');
			}
		} else {
			$balance = $qty_audit - $qty_2 - $qty_1_approved - $qty_1_repaired - $qty_1_cleaned;
			if ($balance < 0) {
				// dd($balance);
				dd('Balance can not be less than 0 !');
			}
			// dd($balance);			
		}

		try {	
			$box = second_quality_bag::findOrFail($id);
			$box->qty_audit = $qty_audit;
			$box->qty_2 = $qty_2;
			$box->qty_1_approved = $qty_1_approved;
			$box->qty_1_repaired = $qty_1_repaired;
			$box->qty_1_cleaned = $qty_1_cleaned;
			$box->balance = $balance;
			$box->qty_2 = $qty_2;

			$box->coment = $coment;
			
			$box->save();
			
		}
		catch (\Illuminate\Database\QueryException $e) {
			// dd('problem to save');
			$msg = 'Problem to save';
			return view('audit.scan_bag_audit', compact('msg'));
		}


		if ($balance == 0) {
			$box = second_quality_bag::findOrFail($id);
			$box->status = 'AUDIT_CHECKED';
			$box->bag_in_audit = date('Y-m-d H:i:s');
			$box->save();
			
		}

		return Redirect::to('/');
	}

	public function cancel_bag(Request $request)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag_id = (int)$input['id'];
		$bag = strtoupper($input['bag']);

		return view('audit.cancel_bag', compact('bag_id', 'bag'));
	}

	public function cancel_confirm(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag_id = (int)$input['bag_id'];
		// dd($bag_id);

		$box = second_quality_bag::findOrFail($bag_id);
		$box->status = 'CANCELED';
		$box->save();

		return Redirect::to('/');
	}

	public function change_bag_po(Request $request)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag_id = (int)$input['id'];
		$bag = strtoupper($input['bag']);

		return view('audit.change_bag_po', compact('bag_id', 'bag'));
	}

	public function change_bag_po_confirm(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag_id = (int)$input['bag_id'];
		$bag = $input['bag'];
		// dd($bag_id);

		$pro = $input['proo'];
		// $proo = $input['proo'];
		// dd($pro);

		//check pro
		$st_info = DB::connection('sqlsrv2')->select(DB::raw("SELECT [POnum] as pro,
				s.Variant,
				st.StyCod,
				[Approval] as app
			FROM [BdkCLZG].[dbo].[CNF_PO] as p
			JOIN [BdkCLZG].[dbo].[CNF_SKU] as s ON s.INTKEY = p.SKUKEY
			JOIN [BdkCLZG].[dbo].[CNF_STYLE] as st ON st.INTKEY = s.STYKEY
			WHERE [POnum] = '".$pro."' 
			UNION 
			SELECT [POnum] as pro,
				s.Variant,
				st.StyCod,
				[Approval] as app
			FROM [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO] as p
			JOIN [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_SKU] as s ON s.INTKEY = p.SKUKEY
			JOIN [172.27.161.221\INTEOSKKA].[BdkCLZKKa].[dbo].[CNF_STYLE] as st ON st.INTKEY = s.STYKEY
			WHERE [POnum] = '".$pro."' 
			"));

			if (!isset($st_info[0]->pro)) {
				// dd('Pro is not valid or it is closed');
				$msg = 'Pro/komesa is not valid or it is closed';
				
				return view('audit.change_bag_po', compact('bag_id', 'bag','msg'));
		}
		else {

			// dd($st_info[0]->pro);
			$brlinija = substr_count($st_info[0]->Variant,"-");
			// dd($brlinija);
			if ($brlinija == 2)
			{
				list($ColorCode, $size1, $size2) = explode('-', $st_info[0]->Variant);
				$Size = $size1."-".$size2;
				// echo $color." ".$size;	
			} else {
				list($ColorCode, $Size) = explode('-', $st_info[0]->Variant);
				// echo $color." ".$size;
			}

			$color = $ColorCode;
			$size = $Size;
		}
		// dd("col: ".$color." , size: ".$size);

		$color = str_pad($color, 4);
		$size = str_pad($size, 5);
		$style = str_pad($st_info[0]->StyCod, 9);
		$sap_sku = $style.$color.$size;
		// dd($sap_sku);
		$app = $st_info[0]->app;
		

		$box = second_quality_bag::findOrFail($bag_id);
		// $box->status = '';
		$box->pro = $pro;
		$box->approval = $app;
		$box->style = trim($style);
		$box->color = trim($color);
		$box->size = trim($size);
		$box->sap_sku = trim($sap_sku);
		// $box->status = '';
		$box->save();

		return Redirect::to('/');
	}

	public function scan_bag_audit_info(Request $request) {
	
		return view('audit.scan_bag_info');
	}

	public function scan_bag_audit_info_post(Request $request) {
		
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag = strtoupper($input['bag']);

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' ORDER BY id asc"));
		// dd($data);

		return view('audit.table', compact('data'));
	}

	public function change_bag_status(Request $request) {
		
		return view('audit.change_bag_status');
	}

	public function change_bag_status_post(Request $request) {
		
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);

		$bag = strtoupper($input['bag']);
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' AND status = 'AUDIT_CHECKED' ORDER BY id asc"));

		if (isset($data[0]->id)) {
			
			$box = second_quality_bag::findOrFail($data[0]->id);
			$box->status = 'AUDIT_TO_DO';
			$box->save();

			$msg2 = 'Status succesfuly changed';
			return view('audit.change_bag_status', compact('msg2'));

		} else {
			$msg = 'Bag not found or bag doesent have status AUDIT_CHECKED';
			return view('audit.change_bag_status', compact('msg'));
		}
	}
}
