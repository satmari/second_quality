<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use Maatwebsite\Excel\Facades\Excel;

use Request; // for import
// use Illuminate\Http\Request; // for image

use App\second_q_box;

use DB;
// use Carbon;

class second_q extends Controller {

	public function index()
	{
		//
		return view('second_q.import');
	}

	public function import_post_second_q(Request $request) {

		$getSheetName = Excel::load(Request::file('file'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            DB::table('second_q_boxes')->truncate();
				// DB::statement('SET FOREIGN_KEY_CHECKS=1;');

	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file'))->chunk(5000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	// dd($row);

	                	// $table->string('box')->nullable();
						// $table->string('item')->nullable();
						// $table->string('color')->nullable();
						// $table->string('size')->nullable();
						// $table->string('barcode')->nullable();
						// $table->integer('qty')->nullable();
						// $table->integer('b3')->nullable();
	                	// dd($row['box']);

						$userbulk = new second_q_box;

						$userbulk->box = $row['box'];
						$userbulk->item = $row['item'];
						$userbulk->color = $row['color'];
						$userbulk->size = $row['size'];
						$userbulk->barcode = $row['barcode'];
						$userbulk->qty = (int)$row['qty'];
						$userbulk->b3 = $row['b3'];
						$userbulk->type = $row['type'];
												
						$userbulk->save();
	                }
	            });
	    }
		return redirect('/magacin_shipment');


	}

}
