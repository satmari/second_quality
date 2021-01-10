<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondQBoxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('second_q_boxes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('box')->nullable();
			$table->string('item')->nullable();
			$table->string('color')->nullable();
			$table->string('size')->nullable();
			$table->string('barcode')->nullable();
			$table->integer('qty')->nullable();
			$table->string('b3')->nullable();
			$table->string('brand')->nullable();
			$table->string('type')->nullable();
			$table->string('printed')->nullable();
			
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
		Schema::drop('second_q_boxes');
	}

}
