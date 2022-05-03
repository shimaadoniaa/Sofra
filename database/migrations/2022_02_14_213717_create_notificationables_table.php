<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationablesTable extends Migration {

	public function up()
	{
		Schema::create('notificationables', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('notificationable_id');
			$table->integer('order_id');
			$table->string('notificationable_type');
			$table->string('title', 50);
			$table->string('content', 150);
			$table->boolean('read')->default(false);
		});
	}

	public function down()
	{
		Schema::drop('notificationables');
	}
}
