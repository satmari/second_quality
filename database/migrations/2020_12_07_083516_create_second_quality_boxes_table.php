<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondQualityBoxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('second_quality_boxes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('box')->unique();

			$table->string('style_2')->nullable();
			$table->string('approval')->nullable();

			$table->string('box_status')->nullable();
			$table->string('box_location')->nullable();

			$table->integer('box_qty_standard');
			$table->integer('box_qty')->nullable();

			$table->string('shipment_status')->nullable();
			$table->string('shipment')->nullable();


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
		Schema::drop('second_quality_boxes');
	}

}
