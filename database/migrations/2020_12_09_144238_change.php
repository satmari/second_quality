<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Change extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('second_quality_bags', function (Blueprint $table) {
  //   		// $table->string('shift')->nullable();

  //   		$table->string('ean')->nullable();
		// 	$table->string('brand')->nullable();

		// 	$table->integer('pcs_per_polybag')->nullable();
		// 	$table->integer('pcs_per_box')->nullable();

		// 	$table->string('style_2')->nullable();
		// 	$table->string('color_2')->nullable();
		// 	$table->string('size_2')->nullable();
		// 	$table->string('col_desc_2')->nullable();
		// 	$table->string('ean_2')->nullable();

		// 	$table->integer('pcs_per_polybag_2')->nullable();
		// 	$table->integer('pcs_per_box_2')->nullable();
			
			// $table->string('barcode_type')->nullable();
			// $table->dateTime('bag_exported_date')->nullable();

			// $table->dateTime('bag_in_audit')->nullable();
			
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
