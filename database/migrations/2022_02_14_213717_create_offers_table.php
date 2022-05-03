<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 50);
			$table->string('content', 200);
			$table->string('img');
            $table->datetime('from_date');
            $table->datetime('to_date');
			$table->integer('restaurant_id');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
