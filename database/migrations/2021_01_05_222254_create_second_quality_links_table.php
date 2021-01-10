<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondQualityLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('second_quality_links', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('bag_id');
			$table->string('bag');

			$table->integer('bag_qty')->nullable();

			$table->integer('box_id');
			$table->string('box');

			$table->integer('box_qty')->nullable();

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
		Schema::drop('second_quality_links');
	}

}
