<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondQualitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('second_quality', function(Blueprint $table)
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
		Schema::drop('second_quality');
	}

}
