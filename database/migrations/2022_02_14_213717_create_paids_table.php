<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaidsTable extends Migration {

	public function up()
	{
		Schema::create('paids', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('amount');
			$table->integer('restaurant_id');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('paids');
	}
}
