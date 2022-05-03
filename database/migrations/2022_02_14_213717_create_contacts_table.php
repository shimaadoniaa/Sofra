<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 50);
			$table->string('email', 50);
			$table->bigInteger('phone');
			$table->string('msg', 200);
			$table->enum('type', array('complaint', 'Suggestion', 'Enquiry'));
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}
