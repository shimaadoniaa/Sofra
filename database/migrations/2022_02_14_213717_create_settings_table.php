<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('about_app');
			$table->text('social_media');
			$table->text('account_restaurant');
			$table->decimal('paid');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
