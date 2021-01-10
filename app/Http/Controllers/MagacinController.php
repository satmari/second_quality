<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\QueryException as QueryException;
use App\Exceptions\Handler;

use Illuminate\Http\Request;
//use Gbrock\Table\Facades\Table;
use Illuminate\Support\Facades\Redirect;

use App\second_quality_bag;
use App\second_quality_box;
use App\second_quality_link;
use App\shipment_header;

use App\temp_bag_location;
use DB;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;

use Session;
use Validator;

class MagacinController extends Controller {

	public function index() {
		//
		// dd('index');
		return view('Magacin.index');
	}

	public function table() {	
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags ORDER BY bag asc"));
		// dd($data);
		return view('Magacin.table', compact('data'));
	}

	public function table_box() {
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes ORDER BY id asc"));
		// dd($data);
		return view('Magacin.table_box', compact('data'));
	}

	public function table_shipment() {
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [second_quality].[dbo].[shipment_headers] ORDER BY shipment asc "));
		// dd($data);

		return view('Magacin.table_shipment', compact('data'));
	}

	public function magacin_bag() {
		//
		$type = " ";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE (status = 'AUDIT_CHECKED' OR status = 'WH_STOCK') ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_bag', compact('data','type'));
	}

	public function magacin_bag_wh_stock() {
		//
		$type = "(WH_STOCK)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE status = 'WH_STOCK' ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_bag', compact('data','type'));
	}

	public function magacin_bag_audit_checked() {
		//
		$type = "(AUDIT_CHECKED)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE status = 'AUDIT_CHECKED' ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_bag', compact('data','type'));
	}

	public function magacin_bag_in_box() {
		//
		$type = "(IN_BOX)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE status = 'IN_BOX' ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_bag', compact('data','type'));
	}

	public function magacin_box() {
		//
		$type = "(FILLING)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE (box_status = 'FILLING') ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_box', compact('data','type'));
	}

	public function magacin_box_on_shipment() {
		//
		$type = "(ON_SHIPMENT)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE (box_status = 'ON_SHIPMENT') ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_box', compact('data','type'));
	}

	public function magacin_box_shipped() {
		//
		$type = "(SHIPPED)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE (box_status = 'SHIPPED') ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_box', compact('data','type'));
	}

	public function magacin_box_closed() {
		//
		$type = "(FULL or CLOSED)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE (box_status = 'FULL') OR (box_status = 'CLOSED') ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_box', compact('data','type'));
	}

	public function magacin_shipment() {
		//
		$type = "(OPEN)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM shipment_headers WHERE (shipment_status = 'OPEN') ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_shipment', compact('data','type'));
	}

	public function magacin_shipment_closed() {
		//
		$type = "(CLOSED)";
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM shipment_headers WHERE (shipment_status = 'CLOSED') ORDER BY id asc"));
		// dd($data);
		return view('Magacin.magacin_shipment', compact('data','type'));
	}

	public function scan_bag_magacin(Request $request) {
	
		return view('Magacin.scan_bag');
	}

	public function scan_bag_location(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag = strtoupper($input['bag']);
		// dd('bag is: '.$bag);

		$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' AND (status = 'AUDIT_CHECKED' OR status = 'WH_STOCK') "));
		// dd($bag_exist);

		if (!isset($bag_exist[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag not exist in table or status of bag is different than AUDIT_CHECKED';
			return view('magacin.scan_bag', compact('msg'));
		}
		$id = $bag_exist[0]->id;
		
		return view('Magacin.scan_location', compact('id','bag'));
	}

	public function scan_confirm_location(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$id = $input['id'];
		$bag = strtoupper($input['bag']);
		$location = strtoupper($input['location']);

		$box = second_quality_bag::findOrFail($id);
		$box->status = 'WH_STOCK';
		$box->location = $location;
		$box->save();

		return Redirect::to('/');
	}

	public function scan_multiple() {
		//
		// dd($data);
		return view('Magacin.scan_bag_multiple');
	}
	
	public function scan_bag_multiple_location(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$location = strtoupper($input['location']);
		// dd($location);

		$msg;
		$bags;
		return view('magacin.scan_bag_multiple_bags', compact('msg','bags','location'));
	}

	public function scan_bag_multiple_location_scan(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$location = strtoupper($input['location']);
		$bag = strtoupper($input['bag']);
		// dd('bag is: '.$bag);

		$already_in_bags = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM temp_bag_locations WHERE bag = '".$bag."' "));			
		// dd($already_in_bags);

		if (isset($already_in_bags[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag already scaned';
			$bags = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM temp_bag_locations ORDER BY id desc"));
			// dd($bags);
			return view('magacin.scan_bag_multiple_bags', compact('msg','bags','location'));
		}

		$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' AND (status = 'AUDIT_CHECKED' OR status = 'WH_STOCK') "));
		
		if (!isset($bag_exist[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag not exist in table or status of bag is different than AUDIT_CHECKED or WH_STOCK';
			$bags = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM temp_bag_locations ORDER BY id desc"));
			return view('magacin.scan_bag_multiple_bags', compact('msg','bags','location'));
		}

		// $id = $bag_exist[0]->id;

		$loc = new temp_bag_location;
		$loc->bag = $bag;
		$loc->save();


		$msg = 'Succesfuly added';
		$bags = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM temp_bag_locations ORDER BY id desc"));
		return view('magacin.scan_bag_multiple_bags', compact('msg','bags','location'));
	}

	public function scan_bag_multiple_location_post(Request $request) {

		$input = $request->all(); // change use (delete or comment user Requestl; )
		$location = $input['location'];
		
		$bags = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM temp_bag_locations ORDER BY id desc"));

		foreach ($bags as $line) {
			// dd($line->bag);

			$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$line->bag."' "));
			// dd($bag_exist[0]);
			$id = $bag_exist[0]->id;
			// dd($id);

			$bag = second_quality_bag::findOrFail($id);
			$bag->status = 'WH_STOCK';
			$bag->location = $location;
			$bag->save();

			$bags = DB::connection('sqlsrv')->select(DB::raw("TRUNCATE TABLE [second_quality].[dbo].[temp_bag_locations]; SELECT * FROM temp_bag_locations ORDER BY id desc"));

		}

		return Redirect::to('/');
	}

	public function scan_bag_to_box() {

		return view('magacin.scan_bag_to_box');
	}

	public function add_bag_to_box(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$bag = strtoupper($input['bag']);
		// dd($bag);

		$bag_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT id, sap_sku, pro, approval, qty_2 FROM second_quality_bags WHERE bag = '".$bag."' AND (status = 'AUDIT_CHECKED' OR status = 'WH_STOCK') "));
		// dd($bag_exist);

		if (!isset($bag_exist[0]->id)) {
			// dd('this bag already exist in table');
			$msg = 'This bag doesn\'t exist in Bag table or status of this bag is different than AUDIT_CHECKED or WH_STOCK';
			return view('magacin.scan_bag_to_box', compact('msg'));
			// return view('magacin.error', compact('msg'));
		}
		$id = $bag_exist[0]->id;
		$sap_sku = $bag_exist[0]->sap_sku;
		$pro = $bag_exist[0]->pro;
		$approval = $bag_exist[0]->approval;
		$qty_2 = $bag_exist[0]->qty_2;

		// dd($pro);
		// dd($approval);
		// $sap_sku = "1234567890123456789";
		$style = trim(substr($sap_sku, 0 , 9));
		// dd($style);
		$color = trim(substr($sap_sku, 9 , 4));
		// dd($color);
		$size = trim(substr($sap_sku, 13 , 5));
		// dd($size);
		
		// Brand + Ean
		$brand_search = DB::connection('sqlsrv2')->select(DB::raw("SELECT 
		      [POnum]
		      ,[EANCode]
		      ,[Brand]
		  FROM [BdkCLZG].[dbo].[CNF_PO]
		  WHERE POnum = '".$pro."'

		  UNION 

		  SELECT 
		  [POnum]
		  ,[EANCode]
		  ,[Brand]
		  FROM [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO]
		  WHERE POnum = '".$pro."' "));
		// dd($brand_search);

		if (!isset($brand_search[0]->Brand)) {
			$msg = 'Brand not exist in inteos table';
			return view('magacin.scan_bag_to_box', compact('msg'));
			// return view('magacin.error', compact('msg'));
		}
		// dd($brand_search);
		$brand = $brand_search[0]->Brand;
		$ean = $brand_search[0]->EANCode;
		

		if ($brand == 'INT') {
			$brand = "Intimissimi";
		} else if ($brand == 'TZN') {
			$brand = "Tezenis";
		} else if ($brand == 'CLZ') {
			$brand = "Calzedonia";
		} else {
			$brand = '';
			$msg = 'Brand not exist in inteos table';
			return view('magacin.scan_bag_to_box', compact('msg'));
			// return view('magacin.error', compact('msg'));
		}
		// dd($brand);
		// dd($ean);

		/*
		// FROM UMESHA file
		// style_2, color_2, size_2, col_desc_2, ean_2
		$search_umesa = DB::connection('sqlsrv4')->select(DB::raw("SELECT 
	      [Item No_] as style
	      ,[Color] as color
	      ,[TG] as size
	      
	      ,[Materiale] as style_2
	      ,[Commersial Color code] as color_2
	      ,[TG2] as size_2
	      
	      --,[Commersial Color code]
	      --,[Color decstionption]
	      ,[Commersial Color code] + ' ' + [Color decstionption] as col_desc_2
	      ,[Barcode] as ean_2
	      
		  --,*
		  FROM [preparation].[dbo].[Barcode Table Quality]
		  
		  --WHERE [Item No_] = 'CMU12G' and [Color] = '031' and [TG] = 'L'
		  --WHERE [Item No_] = '1MT779AT' and [Color] = '196U' and [TG] = 'M'
		  --WHERE [Item No_] = 'MODC1713' and [Color] = '303C' and [TG] = 'S'

		  WHERE [Item No_] = '".$style."' AND [Color] = '".$color."' AND [TG] = '".$size."' "));

		dd($search_umesa);

		if (!isset($search_umesa[0]->style_2)) {
			$msg = 'Second Quality informarion does not exist in Umesa table';
			return view('magacin.scan_bag_to_box', compact('msg'));
			return view('magacin.error', compact('msg'));
		}

		$style_2 = $search_umesa[0]->style_2;
		$color_2 = $search_umesa[0]->color_2;
		$size_2 = $search_umesa[0]->size_2;
		$col_desc_2 = $search_umesa[0]->col_desc_2;
		$ean_2 = $search_umesa[0]->ean_2;
		*/

		// $size = $size + 'HHH'; // test

		// FROM boxsettings table
		$search_boxsettings = DB::connection('sqlsrv5')->select(DB::raw("SELECT [material]
		      ,[style]
		      ,[color]
		      ,[size]
		      ,[brand]
		      ,[pcs_per_polybag]
		      ,[pcs_per_box]
		      ,[pcs_per_box_2]
		      ,[pcs_per_polybag_2]
		      ,[style_2]
		      ,[color_2]
		      ,[size_2]
		      ,[col_desc_2]
		      ,[ean_2]
		  FROM [settings].[dbo].[box_settings]
		  WHERE [style]= '".$style."' AND [color] = '".$color."' AND [size] = '".$size."' "));
		// dd('style: '.$style.' , color: '.$color.' , size: '.$size);
		// dd($search_boxsettings);

		if (!isset($search_boxsettings[0]->style_2)) {
			$msg = 'This sku code doesn\'t exist in box settings table';
			return view('magacin.scan_bag_to_box', compact('msg'));
			// return view('magacin.error', compact('msg'));
		}

		
  		$error = 'Missing: ';

  		if (is_null($search_boxsettings[0]->pcs_per_polybag) OR (int)$search_boxsettings[0]->pcs_per_polybag == 0) {
			// dd($search_boxsettings[0]->pcs_per_polybag);
			$error .= 'pcs_per_polybag, ';
			// dd("pcs_per_polybag is missing");
		} else {
			$pcs_per_polybag = (int)$search_boxsettings[0]->pcs_per_polybag;
		}

		if (is_null($search_boxsettings[0]->pcs_per_box) OR (int)$search_boxsettings[0]->pcs_per_box == 0) {
			// dd($search_boxsettings[0]->pcs_per_box);
			$error .= 'pcs_per_box, ';
			// dd("pcs_per_box is missing");
		} else {
			$pcs_per_box = (int)$search_boxsettings[0]->pcs_per_box;
		}

		if (is_null($search_boxsettings[0]->style_2) OR $search_boxsettings[0]->style_2 == '') {
			// dd($search_boxsettings[0]->style_2);
			$error .= 'style_2, ';
			// dd("style_2 is missing");
		} else {
			$style_2 = $search_boxsettings[0]->style_2;
		}

		if (is_null($search_boxsettings[0]->color_2) OR $search_boxsettings[0]->color_2 == '') {
			// dd($search_boxsettings[0]->color_2);
			$error .= 'color_2, ';
			// dd("color_2 is missing");
		} else {
			$color_2 = $search_boxsettings[0]->color_2;
		}

		if (is_null($search_boxsettings[0]->size_2) OR $search_boxsettings[0]->size_2 == '') {
			// dd($search_boxsettings[0]->size_2);
			$error .= 'size_2, ';
			// dd("size_2 is missing");
		} else {
			$size_2 = $search_boxsettings[0]->size_2;
		}

		if (is_null($search_boxsettings[0]->col_desc_2) OR $search_boxsettings[0]->col_desc_2 == '') {
			// dd($search_boxsettings[0]->col_desc_2);
			$error .= 'col_desc_2, ';
			// dd("col_desc_2 is missing");
		} else {
			$col_desc_2 = $search_boxsettings[0]->col_desc_2;
		}

		if (is_null($search_boxsettings[0]->ean_2) OR $search_boxsettings[0]->ean_2 == '') {
			// dd($search_boxsettings[0]->ean_2);
			$error .= 'ean_2, ';
			// dd("ean_2 is missing");
		} else {
			$ean_2 = $search_boxsettings[0]->ean_2;
		}
		
		if ($brand != 'Intimissimi') {
		
			if (is_null($search_boxsettings[0]->pcs_per_polybag_2) OR (int)$search_boxsettings[0]->pcs_per_polybag_2 == 0) {
				// dd($search_boxsettings[0]->pcs_per_polybag_2);
				$error .= 'pcs_per_polybag_2, ';
				// dd("pcs_per_polybag_2 is missing");
			} else {
				$pcs_per_polybag_2 = (int)$search_boxsettings[0]->pcs_per_polybag_2;
			}

			if (is_null($search_boxsettings[0]->pcs_per_box_2) OR (int)$search_boxsettings[0]->pcs_per_box_2 == 0) {
				// dd($search_boxsettings[0]->pcs_per_box_2);
				$error .= 'pcs_per_box_2, ';
				// dd("pcs_per_box_2 is missing");
			} else {
				$pcs_per_box_2 = (int)$search_boxsettings[0]->pcs_per_box_2;
			}

		} else {
			$pcs_per_polybag_2 = NULL;
			$pcs_per_box_2 = NULL;

		}
		
		if ($error != 'Missing: ') {
			// dd($error);
			$msg = $error . ' for style: '.$style.' , color: '.$color. ' , size: '.$size .' ';
			return view('magacin.error', compact('msg','style','color','size'));
			// return view('magacin.scan_bag_to_box', compact('msg'));
		} else {
			// dd('Ok');
			// dd($id);

			$bag_new = second_quality_bag::findOrFail($id);

			// $bag_new->style = $style;
			// $bag_new->color = $color;
			// $bag_new->size = $size;
			// $bag_new->approval = $approval;

			$bag_new->ean = $ean;		//inteos
			$bag_new->brand = $brand;	//inteos

			$bag_new->pcs_per_polybag = $pcs_per_polybag;	// box settings
			$bag_new->pcs_per_box = $pcs_per_box;			// box settings

			$bag_new->style_2 = $style_2;					// box settings - umesha
			$bag_new->color_2 = $color_2;					// box settings - umesha
			$bag_new->size_2 = $size_2;						// box settings - umesha
			$bag_new->col_desc_2 = $col_desc_2;				// box settings - umesha
			$bag_new->ean_2 = $ean_2;						// box settings - umesha

			$bag_new->pcs_per_polybag_2 = $pcs_per_polybag_2;	// box settings - old conf file - manualy
			$bag_new->pcs_per_box_2 = $pcs_per_box_2;			// box settings - old conf file - manualy

			// $bag_new->status = 'IN_BOX';

			$bag_new->save();
		}

		// DEFINE standard qty

		if ($brand == 'Intimissimi') {
			$box_qty_standard = (int)$pcs_per_box;
		} else {
			$box_qty_standard = (int)$pcs_per_box_2;
		}
		// var_dump((int)$box_qty_standard);
		// var_dump((int)$qty_2);

		// CHECK if BOX exist
		$box_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT *
		  FROM second_quality_boxes
		  WHERE style_2 = '".$style_2."' AND approval = '".$approval."' AND box_status = 'FILLING' "));
		// dd($box_exist);

		if (isset($box_exist[0]->id)) {
			// var_dump("box exist");
				
			// find existing qty in box (1.2.)
			$existing_box_qty = (int)$box_exist[0]->box_qty;
			// dd('existing qty: '.$existing_box_qty.' , new bag qty: '.$qty_2);
			$new_qty = $existing_box_qty+$qty_2;
			// dd($new_qty);
			// $box_qty_standard = 2;

			if ($box_qty_standard >= $new_qty) {
				// var_dump("fill existing box and with bag qty");

				$style_2 = $box_exist[0]->style_2;
				$approval = $box_exist[0]->approval;
				$box_qty_standard = $box_qty_standard; 	// new box_qty_standard
				$box_qty = $qty_2;						// new box_qty
				$existing_box_qty = $existing_box_qty;
				$no_of_boxes = 1;
				$no_of_boxes_orig = 1;
				$bag_id = $id;
				$bag = $bag;

				$bag_qty = $qty_2;
				$box_id = $box_exist[0]->id;
				$box = $box_exist[0]->box;

				// $msg_i = '<p>Box <b>{{ $box }}</b> was found with proper Stis code <b>{{ $style_2 }}</b> and approval <b>{{ $approval }}</b>, 
				// 			confirm to combine bag <b>{{$bag}}</b> and box <b>{{$box}}</b> ?</p>';

				return view('magacin.one_existing_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','box_id','box','msg_i'));

			} else {
				// var_dump("fill existing box and with bag qty + create new (one or more) box");
				$no_of_boxes = $new_qty / $box_qty_standard;
				$no_of_boxes = ceil($no_of_boxes);
				// dd($new_qty);

				$style_2 = $box_exist[0]->style_2;
				$approval = $box_exist[0]->approval;
				$box_qty_standard = $box_qty_standard; 	// new box_qty_standard
				$box_qty = $qty_2;						// new box_qty
				$existing_box_qty = $existing_box_qty;
				$no_of_boxes;
				$no_of_boxes_orig = $no_of_boxes;
				$bag_id = $id;
				$bag = $bag;

				$bag_qty = $qty_2;
				$box_id = $box_exist[0]->id;
				$box = $box_exist[0]->box;

				// $msg_i = '<p>Box <b>{{ $box }}</b> was found with proper Stis code <b>{{ $style_2 }}</b> and approval <b>{{ $approval }}</b>, 
				// 			confirm to combine bag <b>{{$bag}}</b> and box <b>{{$box}}</b> ?';
				return view('magacin.more_existing_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','box_id','box','msg_i'));
			}

		} else {
			// var_dump("box does not exist");
			// $box_qty_standard = 2;

			if ($box_qty_standard >= $qty_2) {
				// var_dump("create one new box and fill with bag qty");
				$style_2;
				$approval;
				$box_qty_standard;
				$box_qty = $qty_2;
				$existing_box_qty = 0;
				$no_of_boxes = 1;
				$no_of_boxes_orig = 1;
				$bag_id = $id;
				$bag;
				$bag_qty = $qty_2;

				$msg_i = 'Create additional box and fill with qty: '.$box_qty;
				return view('magacin.one_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));

			} else {
				// var_dump("create more boxes and fill with bag qty");

				$no_of_boxes = $qty_2 / $box_qty_standard;
				$no_of_boxes = ceil($no_of_boxes);
				// dd($no_of_boxes);

				$style_2;
				$approval;
				$box_qty_standard;
				$box_qty = $qty_2;
				$existing_box_qty = 0;
				$no_of_boxes;
				$no_of_boxes_orig = $no_of_boxes;
				$bag_id = $id;
				$bag;
				$bag_qty = $qty_2;

				$msg_i = 'Create additional FULL box with standard qty: '.$box_qty_standard;
				return view('magacin.more_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));

			}
		}
	}

	public function one_create_box_post(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$box = strtoupper($input['box']);

		$b_check = substr($box, 0, 3);
		// dd($b_check);
		$b_len = strlen($box);
		// dd($b_len);

		$style_2 = $input['style_2'];
		$approval = $input['approval'];
		$box_qty_standard = (int)$input['box_qty_standard'];
		$box_qty = (int)$input['box_qty'];
		$no_of_boxes = (int)$input['no_of_boxes'];
		$no_of_boxes_orig = (int)$input['no_of_boxes_orig'];
		$existing_box_qty = (int)$input['existing_box_qty'];
		$bag_id = $input['bag_id'];
		$bag = $input['bag'];
		$bag_qty = $input['bag_qty'];

		if (($b_check != 'BOX') OR ($b_len != 8)){

			$msg = 'Box not valid';
			return view('magacin.one_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg'));
		}

		// if box already exist 
		$box_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE box = '".$box."' "));

		if (isset($box_exist[0]->id)) {
			
			$msg = 'Box already exist in table';
			return view('magacin.one_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg'));
		}

		// Save new BOX
		$box_new = new second_quality_box;

		$box_new->box = $box;
		$box_new->style_2 = $style_2;
		$box_new->approval = $approval;
		
		// $box_new->box_status = "FILLING";
		$box_new->box_location = NULL;	
		// dd($box_qty_standard);
		$box_new->box_qty_standard = $box_qty_standard;
		$box_new->box_qty = $box_qty;

		if ($box_new->box_qty == $box_new->box_qty_standard) {
			$box_new->box_status = "FULL";
		} else {
			$box_new->box_status = "FILLING";
		}

		$box_new->save();

		// Save link BAG and BOX
		$link_new = new second_quality_link;

		$link_new->bag_id = $bag_id;
		$link_new->bag = $bag;
		$link_new->bag_qty = $bag_qty;
		
		$link_new->box_id = $box_new->id;	
		$link_new->box = $box_new->box;
		$link_new->box_qty = $box_qty;

		$link_new->save();

		// Save BAG
		$bag_old = second_quality_bag::findOrFail($bag_id);
		$bag_old->status = 'IN_BOX';
		$bag_old->save();

		return Redirect::to('/scan_bag_to_box');
	}

	public function one_existing_box_post(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$style_2 = $input['style_2'];
		$approval = $input['approval'];
		$box_qty_standard = (int)$input['box_qty_standard'];
		$box_qty = (int)$input['box_qty'];
		$no_of_boxes = (int)$input['no_of_boxes'];
		$no_of_boxes_orig = (int)$input['no_of_boxes_orig'];
		$existing_box_qty = (int)$input['existing_box_qty'];
		$bag_id = $input['bag_id'];
		$bag = $input['bag'];

		$bag_qty = (int)$input['bag_qty'];
		$box_id = $input['box_id'];
		$box = $input['box'];

		// Save new BOX
		$box_new = second_quality_box::findOrFail($box_id);

		// $box_new->box = $box;
		// $box_new->style_2 = $style_2;
		// $box_new->approval = $approval;
		
		// $box_new->box_status = "FILLING";
		// $box_new->box_location = NULL;	
		// dd($box_qty_standard);
		$box_new->box_qty_standard = $box_qty_standard;
		$box_new->box_qty = $existing_box_qty + $box_qty;

		if ($box_new->box_qty == $box_new->box_qty_standard) {
			$box_new->box_status = "FULL";
		} else {
			$box_new->box_status = "FILLING";
		}
		$box_new->save();


		// Save link BAG and BOX
		$link_new = new second_quality_link;

		$link_new->bag_id = $bag_id;
		$link_new->bag = $bag;
		$link_new->bag_qty = $bag_qty;
		
		$link_new->box_id = $box_new->id;	
		$link_new->box = $box_new->box;
		$link_new->box_qty = $box_qty;

		$link_new->save();

		// Update old link BAG and BOX

		// Save BAG
		$bag_old = second_quality_bag::findOrFail($bag_id);
		$bag_old->status = 'IN_BOX';
		$bag_old->save();

		return Redirect::to('/scan_bag_to_box');
	}

	public function more_create_box_post(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$box = strtoupper($input['box']);

		$b_check = substr($box, 0, 3);
		// dd($b_check);
		$b_len = strlen($box);
		// dd($b_len);

		$style_2 = $input['style_2'];
		$approval = $input['approval'];
		$box_qty_standard = (int)$input['box_qty_standard'];
		$box_qty = (int)$input['box_qty'];
		$no_of_boxes = (int)$input['no_of_boxes'];
		$no_of_boxes_orig = (int)$input['no_of_boxes_orig'];
		$existing_box_qty = (int)$input['existing_box_qty'];
		$bag_id = $input['bag_id'];
		$bag = $input['bag'];
		$bag_qty = $input['bag_qty'];

		if (($b_check != 'BOX') OR ($b_len != 8)){

			$msg = 'Box not valid';
			return view('magacin.more_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg'));
		}

		// if box already exist 
		$box_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE box = '".$box."' "));

		if (isset($box_exist[0]->id)) {
			
			$msg = 'Box already exist in table';
			return view('magacin.more_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg'));
		}

		if ($no_of_boxes > 1 ) {
			// Save new FULL BOX
			$box_new = new second_quality_box;

			$box_new->box = $box;
			$box_new->style_2 = $style_2;
			$box_new->approval = $approval;
			$box_new->box_status = 'FULL';
			$box_new->box_location = NULL;	
			// dd($box_qty_standard);
			$box_new->box_qty_standard = $box_qty_standard;
			$box_new->box_qty = $box_qty_standard; //

			$box_new->save();

			// Save link BAG and BOX
			$link_new = new second_quality_link;

			$link_new->bag_id = $bag_id;
			$link_new->bag = $bag;
			$link_new->bag_qty = $box_qty_standard;
			
			$link_new->box_id = $box_new->id;	
			$link_new->box = $box_new->box;
			$link_new->box_qty = $box_qty_standard;

			$link_new->save();

			// Save BAG
			$bag_old = second_quality_bag::findOrFail($bag_id);
			$bag_old->status = 'IN_BOX';
			$bag_old->save();

			$no_of_boxes = $no_of_boxes - 1;

			$box_qty = $box_qty - $box_qty_standard;
			$bag_qty = $bag_qty - $box_qty_standard;

		}

		if ($no_of_boxes > 1) {
			
			$msg_i = 'Create additional FULL box with standard qty: '.$box_qty_standard;
			return view('magacin.more_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));

		} elseif ($no_of_boxes == 1) {
			
			if ($bag_qty == $box_qty_standard) {
				
				$msg_i = 'Create additional FULL box with standard qty: '.$box_qty_standard;
				return view('magacin.one_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));

			} else {
				$msg_i = 'Create additional box and fill with remaining qty: '.$box_qty;;
				return view('magacin.one_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));	

			}
		}
	}

	public function more_existing_box_post(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$style_2 = $input['style_2'];
		$approval = $input['approval'];
		$box_qty_standard = (int)$input['box_qty_standard'];
		$box_qty = (int)$input['box_qty'];
		$no_of_boxes = (int)$input['no_of_boxes'];
		$no_of_boxes_orig = (int)$input['no_of_boxes_orig'];
		$existing_box_qty = (int)$input['existing_box_qty'];
		$bag_id = $input['bag_id'];
		$bag = $input['bag'];

		$bag_qty = (int)$input['bag_qty'];
		$box_id = $input['box_id'];
		$box = $input['box'];

		
		// Save new BOX
		$box_new = second_quality_box::findOrFail($box_id);

		// $box_new->box = $box;
		// $box_new->style_2 = $style_2;
		// $box_new->approval = $approval;
		
		$box_new->box_status = "FULL";
		// $box_new->box_location = NULL;	
		// dd($box_qty_standard);
		$box_new->box_qty_standard = $box_qty_standard;
		$box_new->box_qty = $box_qty_standard;

		$box_new->save();


		// Save link BAG and BOX
		$link_new = new second_quality_link;

		$link_new->bag_id = $bag_id;
		$link_new->bag = $bag;
		$link_new->bag_qty = $box_qty_standard - $existing_box_qty;
		
		$link_new->box_id = $box_new->id;
		$link_new->box = $box_new->box;
		$link_new->box_qty = $box_qty_standard - $existing_box_qty;

		$link_new->save();

		// Update old link BAG and BOX

		// Save BAG
		$bag_old = second_quality_bag::findOrFail($bag_id);
		$bag_old->status = 'IN_BOX';
		$bag_old->save();


		$no_of_boxes = $no_of_boxes - 1;

		$box_qty = abs((int)$input['box_qty'] + $existing_box_qty - $box_qty_standard);
		$bag_qty = abs((int)$input['box_qty'] + $existing_box_qty - $box_qty_standard);

		$existing_box_qty = 0;

		if ($no_of_boxes > 1) {

			$msg_i = 'Create additional FULL box with standard qty: '.$box_qty_standard;
			return view('magacin.more_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));

		} elseif ($no_of_boxes == 1) {

			if ($bag_qty == $box_qty_standard) {

				$msg_i = 'Create additional FULL box with standard qty: '.$box_qty_standard;
				return view('magacin.one_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));

			} else {
				$msg_i = 'Create additional box and fill with remaining qty: '.$box_qty;;
				return view('magacin.one_create_box', compact('style_2','approval','box_qty_standard','box_qty','existing_box_qty','no_of_boxes','no_of_boxes_orig','bag_id','bag','bag_qty','msg_i'));	

			}
		}
	}

	public function close_box(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$box_id = $input['box_id'];
		
		$box_new = second_quality_box::findOrFail($box_id);
		$box_new->box_status = "CLOSED";
		$box_new->save();

		return Redirect::to('/magacin_box');
	}

	public function add_new_shipment() {

		return view('Magacin.add_new_shipment');
	}	

	public function add_new_shipment_post(Request $request) {
		//
		$this->validate($request, ['shipment'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment = strtoupper($input['shipment']);
		$approval = $input['approval'];
		$shipment_status = "OPEN";

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT *	FROM shipment_headers
		  WHERE shipment = '".$shipment."' "));
		// dd($data);

		if (isset($data[0]->id)) {
			$msg = "Shipment already exist in table";
			return view('Magacin.add_new_shipment',compact('msg'));
		}

		$shipment_new = new shipment_header;
		$shipment_new->shipment = $shipment;
		$shipment_new->approval = $approval;
		$shipment_new->shipment_status = $shipment_status;
		$shipment_new->save();

		return Redirect::to('/magacin_shipment');
	}

	public function view_bag_boxes(Request $request) {
		//
		// $this->validate($request, ['shipment'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$box = strtoupper($input['box']);
		
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT 
			bag.bag
			,bag.sap_sku
			,REPLACE(LEFT(ISNULL(bag.style_2,'')+'____',9), '_', ' ')+ REPLACE(LEFT(ISNULL(bag.color_2,'')+'____',4), '_', ' ')+ REPLACE(LEFT(ISNULL(bag.size_2,'')+	'____',5), '_', ' ') as sap_sku_2
			,CASE
					WHEN LEN(bag.style) < 9 THEN REPLACE(LEFT(ISNULL('K'+RTRIM(LTRIM(left(bag.sap_sku,9))),'')+'____',9), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(SUBSTRING(bag.sap_sku,10,4))),'')+'____',4), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(right(bag.sap_sku,5))),'')+ '____',5), '_', ' ')
					ELSE REPLACE(LEFT(ISNULL('X'+RTRIM(LTRIM(left(bag.sap_sku,9))),'')+'____',9), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(SUBSTRING(bag.sap_sku,10,4))),'')+'____',4), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(right(bag.sap_sku,5))),'')+ '____',5), '_', ' ')
				 END as sap_sap_sku_2
			,bag.brand
			,bag.pro
			,bag.approval
			,bag.line
			,bag.bag_type
			,bag.qty_2
			,bag.status
			,'|' as I
			,l.bag_qty as link_qty
			,'|' as I
			,box.box
			,box.box_qty
			,box.box_qty_standard
			,box.box_status
			,box.updated_at
			,box.shipment
			,'|' as I
			--,s.shipment
			--,s.shipment_status
			--,*
		      
		  FROM [second_quality].[dbo].[second_quality_bags] as bag
		  JOIN [second_quality].[dbo].[second_quality_links] as l ON l.bag_id = bag.id
		  JOIN [second_quality].[dbo].[second_quality_boxes] as box ON box.id = l.box_id
		  --JOIN [second_quality].[dbo].[shipment_headers] as s ON s.shipment = box.shipment
		  WHERE box.box = '".$box."' "));

		// dd($data);
		return view('magacin.view_bag_boxes', compact('data','box'));
	}

	public function view_boxes_in_shipment(Request $request) {
		//
		// $this->validate($request, ['shipment'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment = strtoupper($input['shipment']);
		$approval = $input['approval'];

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT b.[id]
	      ,b.[box]
	      ,b.[style_2]
	      ,b.[approval]
	      ,b.[box_status]
	      ,b.[box_location]
	      ,b.[box_qty_standard]
	      ,b.[box_qty]
	      ,b.[shipment_status] as box_shipment_status
	      ,b.[shipment]
	      ,b.[created_at]
	      ,b.[updated_at]
	      ,s.[shipment_status]
	      ,s.[approval]
		  FROM [second_quality].[dbo].[second_quality_boxes] as b
		  JOIN [second_quality].[dbo].[shipment_headers] as s ON b.[shipment] = s.[shipment]
		  WHERE s.[shipment] = '".$shipment."' "));
		// dd($data);


		return view('magacin.view_boxes_in_shipment', compact('data','shipment','approval'));
	}

	public function view_bag_boxes_in_shipment(Request $request) {
		//
		// $this->validate($request, ['shipment'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment = strtoupper($input['shipment']);
		$approval = $input['approval'];

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT 
			bag.bag
			,bag.sap_sku
			,REPLACE(LEFT(ISNULL(bag.style_2,'')+'____',9), '_', ' ')+ REPLACE(LEFT(ISNULL(bag.color_2,'')+'____',4), '_', ' ')+ REPLACE(LEFT(ISNULL(bag.size_2,'')+	'____',5), '_', ' ') as sap_sku_2
			,CASE
					WHEN LEN(bag.style) < 9 THEN REPLACE(LEFT(ISNULL('K'+RTRIM(LTRIM(left(bag.sap_sku,9))),'')+'____',9), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(SUBSTRING(bag.sap_sku,10,4))),'')+'____',4), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(right(bag.sap_sku,5))),'')+ '____',5), '_', ' ')
					ELSE REPLACE(LEFT(ISNULL('X'+RTRIM(LTRIM(left(bag.sap_sku,9))),'')+'____',9), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(SUBSTRING(bag.sap_sku,10,4))),'')+'____',4), '_', ' ')+REPLACE(LEFT(ISNULL(RTRIM(LTRIM(right(bag.sap_sku,5))),'')+ '____',5), '_', ' ')
				 END as sap_sap_sku_2
			,bag.brand
			,bag.pro
			,bag.approval
			,bag.line
			,bag.bag_type
			,bag.qty_2
			,bag.status
			,'|' as I
			,l.bag_qty as link_qty
			,'|' as I
			,box.box
			,box.box_qty
			,box.box_qty_standard
			,box.box_status
			,box.updated_at
			--,box.shipment
			,'|' as I
			,s.shipment
			,s.shipment_status
			--,*
		      
		  FROM [second_quality].[dbo].[second_quality_bags] as bag
		  JOIN [second_quality].[dbo].[second_quality_links] as l ON l.bag_id = bag.id
		  JOIN [second_quality].[dbo].[second_quality_boxes] as box ON box.id = l.box_id
		  JOIN [second_quality].[dbo].[shipment_headers] as s ON s.shipment = box.shipment
		  WHERE s.[shipment] = '".$shipment."' "));

		// dd($data);
		return view('magacin.view_bag_boxes_in_shipment', compact('data','shipment','approval'));
	}

	public function view_export_shipment(Request $request) {
		//
		// $this->validate($request, ['shipment'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment = strtoupper($input['shipment']);
		$approval = $input['approval'];

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT 

		   b.box
		   ,CASE
			WHEN bag.[brand] = 'Intimissimi' THEN bag.style
			ELSE bag.style_2
		   END as print_style
		  ,bag.col_desc_2 
		  ,bag.size_2
		   ,CASE
			WHEN bag.[brand] = 'Intimissimi' THEN bag.ean
			ELSE bag.ean_2
		   END as barcode
		   ,CASE
			WHEN bag.[brand] = 'Intimissimi' THEN 'IRREGULAR'
			ELSE ''
		   END as type
		   
	      ,b.[approval]
	      ,b.[box_status]
	      
	      ,b.[box_qty_standard]
	      ,b.[box_qty]
	      
	      ,b.[shipment_status] as box_shipment_status
	      ,b.[shipment]
	      ,s.[shipment_status] as shipment_status
	      /*
	      ,s.*
	      ,l.*
		  ,bag.*
		  */
		   
		  FROM [second_quality].[dbo].[second_quality_boxes] as b
		  JOIN [second_quality].[dbo].[shipment_headers] as s ON b.[shipment] = s.[shipment]
		  LEFT JOIN  [second_quality].[dbo].[second_quality_links] as l ON b.id = l.box_id
		  RIGHT JOIN  [second_quality].[dbo].[second_quality_bags] as bag ON bag.id = l.bag_id
		  WHERE s.[shipment] = '".$shipment."' and s.approval = '".$approval."' 
		   GROUP by	b.box
					,b.approval
					,b.box_status
					,b.box_qty_standard
					,b.box_qty
					,b.shipment_status
					,b.shipment
					,bag.brand
					,bag.style
					,bag.style_2
					,bag.col_desc_2
					,bag.size_2
					,bag.ean
					,bag.ean_2
					,s.shipment_status
					"));
		// dd($data);


		return view('magacin.view_export_shipment', compact('data'));
	}

	public function add_box_to_shipment(Request $request) {
		//
		// $this->validate($request, ['shipment'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment = strtoupper($input['shipment']);
		$approval = $input['approval'];


		return view('magacin.add_box_to_shipment', compact('shipment','approval'));
	}

	public function add_box_to_shipment_post(Request $request) {
		//
		// $this->validate($request, ['box'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
			
		$box = strtoupper($input['box']);
		$shipment = strtoupper($input['shipment']);
		$approval = $input['approval'];
		// dd($box);

		$b_check = substr($box, 0, 3);
		// dd($b_check);
		$b_len = strlen($box);

		if (($b_check != 'BOX') OR ($b_len != 8)){

			$msg = 'Box not valid';
			return view('magacin.add_box_to_shipment', compact('shipment','approval','msg'));			
		}
		
		$box_status = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE box = '".$box."' AND ((box_status = 'CLOSED') OR (box_status = 'FULL')) "));

		if (!isset($box_status[0]->id)) {
			$msg = 'Box '.$box.' doesnt have status FULL or CLOSED';
			return view('magacin.add_box_to_shipment', compact('shipment','approval','msg'));	
		}

		$box_approval = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE box = '".$box."' "));
		
		if ($box_approval[0]->approval != $approval) {
			$msg = 'Box approval "'.$box_approval[0]->approval.'" is not the same as shipment approval "'.$approval.'" ';
			return view('magacin.add_box_to_shipment', compact('shipment','approval','msg'));	
		}
		
		$box_exist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_boxes WHERE box = '".$box."' AND shipment is null AND shipment_status is null"));

		if (isset($box_exist[0]->id)) {
			// dd($box_exist);
			// dd('Box approval: '.$box_approval[0]->approval.' , shipment approval: '.$approval.' ');

			$box_update = second_quality_box::findOrFail($box_exist[0]->id);
			$box_update->shipment = $shipment;
			$box_update->shipment_status = 'ON_SHIPMENT';
			$box_update->box_status = 'ON_SHIPMENT';

			$box_update->save();

			$msg_i = "Box (".$box.") succesfuly added to shipment ".$shipment;
			return view('magacin.add_box_to_shipment', compact('shipment','approval','msg_i'));

		} else {

			$msg = 'Box ('.$box.') already have some shiping information';
			return view('magacin.add_box_to_shipment', compact('shipment','approval','msg'));			
		}
	}

	public function close_shipment(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment_id = $input['id'];
		$shipment = $input['shipment'];

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [second_quality_boxes] 
		  WHERE shipment = '".$shipment."' "));

		if (isset($data[0]->id)) {
			return view('magacin.close_shipment_confirm', compact('shipment_id','shipment'));			

		} else {
			$empty = " ";
			return view('magacin.close_shipment_confirm', compact('shipment_id','shipment','empty'));			
		}
	}

	public function close_shipment_confirm(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment_id = $input['id'];
		$shipment = $input['shipment'];
		
		$s = shipment_header::findOrFail($shipment_id);
		$s->shipment_status = "CLOSED";
		$s->save();

		// Add box_status "SHIPED" to each box in shipment
		$data = DB::connection('sqlsrv')->update(DB::raw("SET NOCOUNT ON; UPDATE second_quality_boxes 
			SET box_status = 'SHIPPED'
			WHERE shipment = '".$shipment."'; SELECT TOP 1 id FROM second_quality_boxes "));

		return Redirect::to('/magacin_shipment');
	}

	public function close_shipment_confirm_delete(Request $request) {
		//
		// $this->validate($request, ['line'=>'required']);
		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		
		$shipment_id = $input['id'];
		$shipment = $input['shipment'];

		$s = shipment_header::findOrFail($shipment_id);
		$s->delete();

		return Redirect::to('/magacin_shipment');
	}

	public function edit_box2 (Request $request) {
		
		//
		$this->validate($request, [
			'style' => 'required', 
			'color'=> 'required', 
			'size'=> 'required',
		]);
		$input = $request->all();
		
		$style = trim(strtoupper($input['style']));
		$color = trim(strtoupper($input['color']));
		$size = trim(strtoupper($input['size']));

		// dd($style);

		$data = DB::connection('sqlsrv5')->select(DB::raw("SELECT * FROM box_settings WHERE style = '".$style."' AND color = '".$color."' AND size = '".$size."'"));
		if (isset($data[0]->id)) {
			// dd($data);
			$data = $data[0];
			return view('magacin.edit_box', compact('data'));	

		} 

		// $data = box_settings::findOrFail($id);		
		// return view('Box.edit_box', compact('data'));
	}

	public function update_box ($id, Request $request) {
		// dd($id);
		//

		$input = $request->all();
		// dd($input);

		$pcs_per_polybag_2 = (int)$input['pcs_per_polybag_2'];
		if ($pcs_per_polybag_2 == 0 OR is_null($pcs_per_polybag_2) ) {
			$pcs_per_polybag_2 = NULL;
		}
		// dd($pcs_per_polybag_2);

		$pcs_per_box_2 = (int)$input['pcs_per_box_2'];
		if ($pcs_per_box_2 == 0 OR is_null($pcs_per_box_2) ) {
			$pcs_per_box_2 = NULL;
		}

		$data = DB::connection('sqlsrv5')->update(DB::raw("SET NOCOUNT ON; UPDATE box_settings 
			SET pcs_per_polybag_2 = '".$pcs_per_polybag_2."',
				pcs_per_box_2 = '".$pcs_per_box_2."'
			WHERE id = '".$id."'; SELECT TOP 1 * FROM box_settings WHERE id = '".$id."' "));

		// dd($data);
		return Redirect::to('magacin');
	}
	
}	