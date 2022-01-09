<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Firstquality extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('first_quality', function(Blueprint $table)
		{
			
			$table->string('pro')->nullable();
			$table->string('sku')->nullable();
			$table->string('style')->nullable();
			$table->integer('qty')->nullable();
			$table->string('hu')->nullable();
			
			
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
