<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration {

	public function up()
	{
		Schema::create('tokens', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('client_id');
			$table->integer('restaurant_id');
			$table->string('token');
			$table->enum('type',['android','ios']);
			$table->timestamps();

		});
	}

	public function down()
	{
		Schema::drop('tokens');
	}
}
