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
use App\bag_label;
use DB;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;

use Session;
use Validator;

class whsuController extends Controller {

	// 1.scan_line
	// 2.scan_bag
	// 3.choose_bag_type
	// 4.select_pro
	// 5.inser_qty and confirm ->(2)

	public function index()	{
		//
		// dd('WHsu');
		// $user = User::find(Auth::id());
		// Session::set('leader', NULL);

		return Redirect::to('/scan_start');
	}

	public function scan_start() {

		return view('whsu.scan_line');
	}

	public function scan_line(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];
		// dd($line);

		//Lazarevac
		if ($line != 'LAZAREVAC') {

			$line_val = DB::connection('sqlsrv2')->select(DB::raw("SELECT [ModNam] as line FROM [BdkCLZG].[dbo].[CNF_Modules] WHERE Active = '1' AND ModNam =  '".$line."' "));
			// dd($line_val);

			if ( !isset($line_val[0]->line)) {
				// dd('Not valid line in Subotica');
				// dd($line);
				$msg = 'Not valid line in Subotica';
				return view('whsu.scan_line', compact('msg'));
			}	
		}
		
		// dd($line);
		return view('whsu.scan_bag', compact('line'));
	}

	public function scan_bag(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];
		$bag = strtoupper($input['bag']);
		// dd($bag);
		$b_check = substr($bag, 0, 2);
		// dd($b_check);

		//Lazarevac
		if ($line != 'LAZAREVAC') {

			if ($b_check != 'BS') {
				// dd('No valid bag barcode');
				$msg = 'No valid bag barcode: '.$bag;
				return view('whsu.scan_bag', compact('line','msg'));
			}

			$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM second_quality_bags WHERE bag = '".$bag."' "));

			if (isset($bag_exist[0]->id)) {
				// dd('this bag already exist in table');
				$msg = 'This bag already exist in table';
				return view('whsu.scan_bag', compact('line', 'msg'));
			}

			return view('whsu.choose_bag_type', compact('line', 'bag'));

		} else {

			if ($b_check != 'BL') {
				// dd('No valid bag barcode');
				$msg = 'No valid bag barcode: '.$bag;
				return view('whsu.scan_bag', compact('line','msg'));
			}

			$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM second_quality_bags WHERE bag = '".$bag."' "));

			if (isset($bag_exist[0]->id)) {
				// dd('this bag already exist in table');
				$msg = 'This bag already exist in table';
				return view('whsu.scan_bag', compact('line', 'msg'));
			}

			return view('whsu.choose_bag_type', compact('line', 'bag'));

		}
		
	}

	public function choose_bag_type(Request $request) {	
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];		
		$bag = $input['bag'];		
		$bag_type = strtoupper($input['bag_type']);		

		// dd($bag_type);
		$pros = DB::connection('sqlsrv2')->select(DB::raw("SELECT [POnum] as pro FROM [BdkCLZG].[dbo].[CNF_PO] WHERE POClosed is null OR POClosed = '0' ORDER BY POnum"));
		// dd($pros);

		return view('whsu.select_pro', compact('line', 'bag', 'bag_type', 'pros'));
	}
	
	public function select_pro(Request $request) {
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];		
		$bag = $input['bag'];		
		$bag_type = $input['bag_type'];	
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
		WHERE [POnum] = '".$pro."' "));

		if (!isset($st_info[0]->pro)) {
			// dd('Pro is not valid or it is closed');
			$msg = 'Pro/komesa is not valid or it is closed';
			$pros = DB::connection('sqlsrv2')->select(DB::raw("SELECT [POnum] as pro FROM [BdkCLZG].[dbo].[CNF_PO] WHERE POClosed is null OR POClosed = '0' ORDER BY POnum"));
			return view('whsu.select_pro', compact('line', 'bag', 'bag_type', 'pros', 'msg'));
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

		return view('whsu.add_qty', compact('line', 'bag', 'bag_type', 'pro', 'sap_sku','app'));

	}

	public function confirm(Request $request) {
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];		
		$bag = $input['bag'];		
		$bag_type = $input['bag_type'];	
		$pro = $input['pro'];
		$sap_sku = $input['sap_sku'];
		$app = $input['app'];
		$qty = (int)$input['qty'];

		$status = "AUDIT_TO_DO";
		$user = User::find(Auth::id())->name;
		// dd($user);

		// $sap_sku = '12345678901234A67';

		$style = trim(substr($sap_sku,0, 9));
		// dd($style);

		$color = trim(substr($sap_sku, 9, 4));
		// dd($color);

		$size = trim(substr($sap_sku, 13, 5));
		// dd($size);

		//Record Header
		try {
			$table = new second_quality_bag;

			$table->bag = $bag;
			$table->pro = $pro;
			$table->approval = $app;
			$table->style = $style;
			$table->color = $color;
			$table->size = $size;
			$table->sap_sku = $sap_sku;

			$table->bag_type = $bag_type;
			$table->line = $line;

			$table->qty = $qty;
			$table->user = $user;
			$table->status = $status;

			$table->save();
			
		}
		catch (\Illuminate\Database\QueryException $e) {
			// dd("Problem to save in table second_quality");
			$msg = 'Problem to save in table second_quality, maybe this bag is already in table';
			return view('whsu.add_qty', compact('line', 'bag', 'bag_type', 'pro', 'sap_sku','app','msg'));

		}

		$msgs = 'Bag succesfuly saved';
		return view('whsu.scan_bag', compact('line', 'msgs'));

	}

	public function transfer_to_subotica(Request $request) {
		// dd('test');

		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);

		if (isset($input)) {

			if (!empty($input) OR $input) {
			
				// dd('test');
				$bag = strtoupper($input['bag']);
				// dd($bag);
				
				$check = substr($bag, 0, 2);
				// dd($check);

				if (($check == 'BS') OR ($check == 'BK')) {
					
					$bag_id = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' "));
					// dd($bag_id[0]->id);

					if (isset($bag_id[0]->id) AND ($bag_id[0]->status == 'PICKED_IN_KI')) {
						
						try {	
							$box = second_quality_bag::findOrFail($bag_id[0]->id);
							$box->status = 'AUDIT_TO_DO';
							$box->save();
							
						}
						catch (\Illuminate\Database\QueryException $e) {
							dd('problem to save');
							$msge = 'Problem to save: '.$bag;
							return view('whsu.transfer_bag', compact('msge'));
						}

						$msgs = 'Succesfuly saved: '.$bag;
						return view('whsu.transfer_bag', compact('msgs'));

					} else {
						$msge = 'Bag barcode not found in table, or status is different than BK0002 ';
						return view('whsu.transfer_bag', compact('msge'));
					}

				} else {
					$msge = 'Bag barcode is not correct';
					return view('whsu.transfer_bag', compact('msge'));
				}
			} else {
				// $msge = 'Bag barcode is not correct';
				return view('whsu.transfer_bag');			
			}
		} else {
			// $msge = 'Bag barcode is not correct';
			return view('whsu.transfer_bag');			

		}

	}

	public function print_bag_su() {

		return view('whsu.print_bag_su');			
	}

	public function print_bag_su_confirm(Request $request) {

		$input = $request->all(); 
		// dd($input);
		
		if ($input['printer_name'] == '' OR $input['from'] == '' OR $input['to'] == '' OR $input['labels'] == '') {

			$msge = 'All fields should be populated';
			return view('whsu.print_bag_su', compact('msge'));
		}

		$printer = $input['printer_name'];
		$labels = $input['labels'];
		$from = (int)$input['from'];
		$to = (int)$input['to'];

		$numberoflabels = $to - $from;

		return view('whsu.print_bag_su_confirm_print', compact('printer','labels','from','to','numberoflabels'));
	}

	public function print_bag_su_confirm_print(Request $request) {

		$input = $request->all(); 
		// dd($input);
		
		$printer = $input['printer'];
		$labels = $input['labels'];
		$from = $input['from'];
		$to = $input['to'];

		for ($i=$from; $i < $to; $i++) { 
			
			$num = str_pad($i, 5, 0, STR_PAD_LEFT);

			// var_dump('BS'.$num);

			
			$box = new bag_label;
			$box->bag = $labels.''.$num;
			// dd($box->bag);

			if ($labels == 'BOX') {

				$box_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE box = '".$box->bag."' "));
				if (isset($box_exist[0]->id)) {
					continue;
				}

			} else {
				$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$box->bag."' "));
				if (isset($bag_exist[0]->id)) {
					continue;
				}
			}
			
			$box->printer = $printer;
			$box->printed = 0;
			$box->save();

			// var_dump($box->bag);
		}

		return Redirect::to('/');
	}

	

}
