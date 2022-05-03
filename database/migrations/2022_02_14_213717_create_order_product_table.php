<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductTable extends Migration {

	public function up()
	{
		Schema::create('order_product', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('order_id');
			$table->string('product_id');
			$table->decimal('price');
			$table->string('amount');
			$table->string('notes');
		});
	}

	public function down()
	{
		Schema::drop('order_product');
	}
}