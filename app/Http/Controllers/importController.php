<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use Maatwebsite\Excel\Facades\Excel;

use Request; // for import
// use Illuminate\Http\Request; // for image

use App\second_quality_bag;

use DB;
// use Carbon;


class importController extends Controller {

	public function index()
	{
		//
		// dd("test");
		return view('Import.index');
		
	}

	public function postImport(Request $request) {
	    $getSheetName = Excel::load(Request::file('file1'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	//DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file1'))->chunk(5000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	
	                	// dd($row);
	                	$bag = $row['bag'];
	                	// dd($bag);


	                	$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM second_quality_bags WHERE bag = '".$bag."' "));
	                	// dd($data);

	                	$style = trim($data[0]->style);
	                	$color = $data[0]->color;
	                	$size = $data[0]->size;
	                	$id = $data[0]->id;

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
						
						// if ($brand != 'Intimissimi') {
						
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

						// } else {
						// 	$pcs_per_polybag_2 = NULL;
						// 	$pcs_per_box_2 = NULL;
						// }
						
						if ($error != 'Missing: ') {
							// dd($error);
							var_dump($error);
							// $msg = $error . ' for style: '.$style.' , color: '.$color. ' , size: '.$size .' ';
							// return view('magacin.error', compact('msg','style','color','size'));
							// return view('magacin.scan_bag_to_box', compact('msg'));
						} else {
							// dd('Ok');
							// dd($id);

							$bag_new = second_quality_bag::findOrFail($id);

							// $bag_new->style = $style;
							// $bag_new->color = $color;
							// $bag_new->size = $size;
							// $bag_new->approval = $approval;

							// $bag_new->ean = $ean;		//inteos
							// $bag_new->brand = $brand;	//inteos

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

							// $bag_new->save();

							var_dump('Done <br>');
						}

					}
	            });
	    }
		return redirect('/');
	}

	public function postImportQty(Request $request) {
	    $getSheetName = Excel::load(Request::file('file2'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	//DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file2'))->chunk(5000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row) {
	                	
	                	// dd($row);
	                	$id = $row['id'];
	                	$qty = ROUND((int)$row['qty'],0);

	                	$bag_new = second_quality_bag::findOrFail($id);
						$bag_new->qty = $qty;
						$bag_new->save();
	                	
					}
            	});
    	}
		return redirect('/');
	}
	
}
