<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('email', 50);
			$table->string('password', 255);
			$table->string('pin_code')->nullable();
			$table->string('phone');
			$table->string('restaurant_name', 50);
			$table->integer('distriction_id')->unsigned();
			$table->decimal('minimum_order');
			$table->string('whatsApp', 50);
			$table->string('img', 50);
			$table->enum('rate', array('1', '2', '3', '4', '5'));
			$table->string('api_token', 255)->nullable();
			$table->enum('status', array('open', 'close'));
			$table->decimal('delivery_fees');
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
