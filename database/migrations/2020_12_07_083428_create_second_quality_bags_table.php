<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondQualityBagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('second_quality_bags', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('bag')->unique();
			$table->string('pro');
			$table->string('approval')->nullable();
			$table->string('style')->nullable();
			$table->string('color')->nullable();
			$table->string('size')->nullable();
			$table->string('sap_sku')->nullable();

			$table->string('bag_type');
			$table->string('line');

			$table->string('user');
			$table->string('status');

			$table->integer('qty');

			$table->integer('qty_audit')->nullable();
			$table->integer('qty_2')->nullable();
			$table->integer('qty_1_approved')->nullable();
			$table->integer('qty_1_repaired')->nullable();
			$table->integer('qty_1_cleaned')->nullable();
			$table->integer('balance')->nullable();

			$table->string('coment')->nullable();			

			$table->string('location')->nullable();	

			$table->string('shift')->nullable();

			$table->string('ean')->nullable();
			$table->string('brand')->nullable();

			$table->integer('pcs_per_polybag')->nullable();
			$table->integer('pcs_per_box')->nullable();

			$table->string('style_2')->nullable();
			$table->string('color_2')->nullable();
			$table->string('size_2')->nullable();
			$table->string('col_desc_2')->nullable();
			$table->string('ean_2')->nullable();

			$table->integer('pcs_per_polybag_2')->nullable();
			$table->integer('pcs_per_box_2')->nullable();
			
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('second_quality_bags');
	}

}
