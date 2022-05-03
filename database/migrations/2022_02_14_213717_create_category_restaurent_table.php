<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryRestaurentTable extends Migration {

	public function up()
	{
		Schema::create('category_restaurent', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('category_id');
			$table->integer('restaurant_id');
		});
	}

	public function down()
	{
		Schema::drop('category_restaurent');
	}
}