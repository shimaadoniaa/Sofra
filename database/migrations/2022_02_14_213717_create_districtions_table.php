<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDistrictionsTable extends Migration {

	public function up()
	{
		Schema::create('districtions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('city_id');
		});
	}

	public function down()
	{
		Schema::drop('districtions');
	}
}