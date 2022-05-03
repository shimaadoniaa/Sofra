<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('client_id', 50);
			$table->string('payment_id');
			$table->text('note');
			$table->bigInteger('phone');
			$table->string('address', 100);
			$table->decimal('commission');
			$table->decimal('delivery');
			$table->decimal('price');
			$table->decimal('total');
			$table->decimal('net');
			$table->enum('status', array('pending-accepted-rejected-confirmed-declined-delivered-cart'));
			$table->integer('restaurant_id');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
