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

class whseController extends Controller {

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

		return Redirect::to('/scan_start_z');
	}

	public function scan_start() {

		return view('whse.scan_line');
	}

	public function scan_line(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$line = $input['line'];
		// dd($line);

		$line_val = DB::connection('sqlsrv2')->select(DB::raw("SELECT [ModNam] as line FROM [BdkCLZG].[dbo].[CNF_Modules] WHERE Active = '1' AND ModNam =  '".$line."' "));
		// dd($line_val);

		if (!isset($line_val[0]->line)) {
			// dd('Not valid line in Senta');
			$msg = 'Not valid line in Senta';
			return view('whse.scan_line', compact('msg'));
		}

		$line_shift = '';
		// return view('whse.choose_line_shift', compact('line'));
		return view('whse.scan_bag', compact('line', 'line_shift' ));
	}

	// public function choose_line_shift(Request $request) {
	// 	//
	// 	// $this->validate($request, ['line'=>'required']);
	// 	$input = $request->all(); // change use (delete or comment user Requestl; )
	// 	// dd($input);
	// 	$line = $input['line'];
	// 	$line_shift = $input['line_shift'];
		
	// 	// return view('whse.scan_bag', compact('line', 'line_shift' ));
	// }

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
			return view('whse.scan_bag', compact('line','line_shift','msg'));
		}

		if ($b_check != 'BZ') {
			// dd('No valid bag barcode');
			$msg = 'No valid bag barcode: '.$bag;
			return view('whse.scan_bag', compact('line','line_shift','msg'));
		}

		$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM second_quality_bags WHERE bag = '".$bag."' "));

		if (isset($bag_exist[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag already exist in table';
			return view('whse.scan_bag', compact('line','line_shift','msg'));
		}

		return view('whse.choose_bag_type', compact('line','line_shift','bag'));
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
		$pros = DB::connection('sqlsrv2')->select(DB::raw("SELECT [POnum] as pro FROM [BdkCLZG].[dbo].[CNF_PO] WHERE POClosed is null OR POClosed = '0' ORDER BY POnum"));
		// dd($pros);

		return view('whse.select_pro', compact('line','line_shift','bag', 'bag_type', 'pros'));
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
		FROM [BdkCLZG].[dbo].[CNF_PO] as p
		JOIN [BdkCLZG].[dbo].[CNF_SKU] as s ON s.INTKEY = p.SKUKEY
		JOIN [BdkCLZG].[dbo].[CNF_STYLE] as st ON st.INTKEY = s.STYKEY
		WHERE [POnum] = '".$pro."' "));

		if (!isset($st_info[0]->pro)) {
			// dd('Pro is not valid or it is closed');
			$msg = 'Pro/komesa is not valid or it is closed';
			$pros = DB::connection('sqlsrv2')->select(DB::raw("SELECT [POnum] as pro FROM [BdkCLZG].[dbo].[CNF_PO] WHERE POClosed is null OR POClosed = '0' ORDER BY POnum"));
			return view('whse.select_pro', compact('line','line_shift','bag', 'bag_type', 'pros', 'msg'));
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

		return view('whse.add_qty', compact('line','line_shift','bag', 'bag_type', 'pro', 'sap_sku','app'));
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

		$status = "PICKED_IN_SE";
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
			$table->style = $style;
			$table->color = $color;
			$table->size = $size;
			$table->sap_sku = $sap_sku;

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
			return view('whse.add_qty', compact('line','line_shift','bag', 'bag_type', 'pro', 'sap_sku','app','msg'));

		}

		$msgs = 'Bag succesfuly saved';
		return view('whse.scan_bag', compact('line','line_shift','msgs'));

	}

	
}
