<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondQualityLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('second_quality_logs', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('module', 10);
			$table->string('line_leader', 40);
			$table->string('type', 30);
			$table->string('po', 15);
			$table->string('size', 5);
			$table->string('item', 10);
			$table->string('color', 5);
			$table->string('color_desc', 50)->nullable();
			$table->integer('module_qty');
			$table->integer('receive_qty')->nullable();
			$table->string('status', 30);
			
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
		Schema::drop('second_quality_logs');
	}

}
