<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->string('img', 255);
			$table->string('details', 255);
            $table->text('special_order', 255)->nullable();
            $table->decimal('price');
			$table->decimal('price_in_offer');
			$table->string('duration_order');
			$table->integer('restaurant_id');
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}
