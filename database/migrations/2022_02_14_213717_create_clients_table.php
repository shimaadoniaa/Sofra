<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('email', 50);
			$table->string('password', 255);
			$table->string('pin_code')->nullable();
			$table->string('name', 50);
			$table->bigInteger('phone');
			$table->integer('distriction_id');
			$table->string('api_token', 60)->unique()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
