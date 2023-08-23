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

class whkiController extends Controller {

	// 1.scan_line
	// 2.scan_bag
	// 3.choose_bag_type
	// 4.select_pro
	// 5.inser_qty and confirm ->(2)

	public function index()	{
		//
		// dd('WHki');
		// $user = User::find(Auth::id());
		// Session::set('leader', NULL);

		return Redirect::to('/scan_start_k');
	}

	public function scan_start() {

		return view('whki.scan_line');
	}

	public function scan_line(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = strtoupper($input['line']);
		// dd($line);

		$line_val = DB::connection('sqlsrv2')->select(DB::raw("SELECT [ModNam] as line FROM [172.27.161.221\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_Modules] WHERE Active = '1' AND ModNam =  '".$line."' "));
		// dd($line_val);

		if ((!isset($line_val[0]->line) AND $line != 'KI-TC' )) {
			// dd('Not valid line in Kikinda');
			$msg = 'Not valid line in Kikinda';
			return view('whki.scan_line', compact('msg'));
		}

		return view('whki.choose_line_shift', compact('line'));
	}

	public function choose_line_shift(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];
		$line_shift = $input['line_shift'];
		
		return view('whki.scan_bag', compact('line', 'line_shift' ));
	}

	public function scan_bag(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];
		$line_shift = $input['line_shift'];
		$bag = strtoupper($input['bag']);
		// dd($bag);
		$b_check = substr($bag, 0, 2);
		// dd($b_check);
		if (strlen($bag) > 8) {
			$msg = 'No valid bag barcode: '.$bag.', probably double scan';
			return view('whsu.scan_bag', compact('line','msg'));
		}

		if ($b_check != 'BK') {
			// dd('No valid bag barcode');
			$msg = 'No valid bag barcode: '.$bag;
			return view('whki.scan_bag', compact('line','line_shift','msg'));
		}

		$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM second_quality_bags WHERE bag = '".$bag."' "));

		if (isset($bag_exist[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag already exist in table';
			return view('whki.scan_bag', compact('line','line_shift','msg'));
		}

		return view('whki.choose_bag_type', compact('line','line_shift','bag'));
	}

	public function choose_bag_type(Request $request) {	
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];		
		$line_shift = $input['line_shift'];		
		$bag = $input['bag'];		
		$bag_type = strtoupper($input['bag_type']);		

		// dd($bag_type);
		$pros = DB::connection('sqlsrv2')->select(DB::raw("SELECT [POnum] as pro FROM [172.27.161.221\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO] WHERE POClosed is null OR POClosed = '0' ORDER BY POnum"));
		// dd($pros);

		return view('whki.select_pro', compact('line','line_shift','bag', 'bag_type', 'pros'));
	}

	public function select_pro(Request $request) {
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];		
		$line_shift = $input['line_shift'];		
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
		FROM [172.27.161.221\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO] as p
		JOIN [172.27.161.221\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_SKU] as s ON s.INTKEY = p.SKUKEY
		JOIN [172.27.161.221\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_STYLE] as st ON st.INTKEY = s.STYKEY
		WHERE [POnum] = '".$pro."' "));

		if (!isset($st_info[0]->pro)) {
			// dd('Pro is not valid or it is closed');
			$msg = 'Pro/komesa is not valid or it is closed';
			$pros = DB::connection('sqlsrv2')->select(DB::raw("SELECT [POnum] as pro FROM [172.27.161.221\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO] WHERE POClosed is null OR POClosed = '0' ORDER BY POnum"));
			return view('whki.select_pro', compact('line','line_shift','bag', 'bag_type', 'pros', 'msg'));
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

		return view('whki.add_qty', compact('line','line_shift','bag', 'bag_type', 'pro', 'sap_sku','app'));

	}

	public function confirm(Request $request) {
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];
		$line_shift = $input['line_shift'];
		$bag = $input['bag'];		
		$bag_type = $input['bag_type'];	
		$pro = $input['pro'];
		$sap_sku = $input['sap_sku'];
		$app = $input['app'];
		$qty = (int)$input['qty'];

		if ($qty > 200) {

			$msg = 'Qty is greater than 200 pcs in the bag, please add the correct qty if it is mistake, if you really have more qty than 200, set qty 200, and after that send mail to IT in order to correct qty in the database.';
			return view('whki.add_qty', compact('line', 'line_shift', 'bag', 'bag_type', 'pro', 'sap_sku','app','msg'));
		}

		$status = "PICKED_IN_KI";
		$user = User::find(Auth::id())->name;
		// dd($user);

		// $sap_sku = '12345678901234A67';

		$style = trim(substr($sap_sku,0, 9));
		// dd($style);

		$color = trim(substr($sap_sku, 9, 4));
		// dd($color);

		$size = trim(substr($sap_sku, 13, 5));
		// dd($size);

		$barcode_type = DB::connection('sqlsrv4')->select(DB::raw("SELECT [Serie] FROM [preparation].[dbo].[Barcode Table Quality] WHERE [Item No_] = '".$style."' AND Color = '".$color."' "));
		if (isset($barcode_type[0])) {
			$b_type = $barcode_type[0]->Serie;
		} else {
			$b_type = '';
		}

		//Record Header
		try {
			$table = new second_quality_bag;

			$table->bag = $bag;
			$table->pro = $pro;
			$table->approval = $app;
			$table->style = trim($style);
			$table->color = trim($color);
			$table->size = trim($size);
			$table->sap_sku = trim($sap_sku);

			$table->bag_type = $bag_type;
			$table->line = $line;

			$table->qty = $qty;
			$table->user = $user;
			$table->status = $status;

			$table->shift = $line_shift;

			$table->barcode_type = $b_type;

			$table->save();
			
		}
		catch (\Illuminate\Database\QueryException $e) {
			// dd("Problem to save in table second_quality");
			$msg = 'Problem to save in table second_quality, maybe this bag is already in table';
			return view('whki.add_qty', compact('line','line_shift','bag', 'bag_type', 'pro', 'sap_sku','app','msg'));

		}

		$msgs = 'Bag succesfuly saved';
		return view('whki.scan_bag', compact('line','line_shift','msgs'));

	}

	public function print_bag_ki() {

		return view('whki.print_bag_ki');
	}

	public function print_bag_ki_confirm(Request $request) {

		$input = $request->all(); 
		// dd($input);
		
		if ($input['printer_name'] == '' OR $input['from'] == '' OR $input['to'] == '') {

			$msge = 'All fields should be populated';
			return view('whki.print_bag_ki', compact('msge'));
		}

		$printer = $input['printer_name'];
		$from = (int)$input['from'];
		$to = (int)$input['to'];

		$numberoflabels = $to - $from;

		return view('whki.print_bag_ki_confirm_print', compact('printer','from','to','numberoflabels'));
	}

	public function print_bag_ki_confirm_print(Request $request) {

		$input = $request->all(); 
		// dd($input);
		
		$printer = $input['printer'];

		// dd($printer);
		$from = $input['from'];
		$to = $input['to'];

		for ($i=$from; $i < $to; $i++) { 
			
			$num = str_pad($i, 5, 0, STR_PAD_LEFT);

			// var_dump('BS'.$num);

			$box = new bag_label;
			$box->bag = 'BK'.$num;

			$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$box->bag."' "));
			if (isset($bag_exist[0]->id)) {
				continue;
			}
			
			$box->printer = $printer;
			$box->printed = 0;
			$box->save();

		}

		return Redirect::to('/');
	}
}
