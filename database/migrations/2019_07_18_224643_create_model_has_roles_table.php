<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModelHasRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('model_has_roles', function(Blueprint $table)
		{
			$table->integer('role_id');
			$table->string('model_type');
			$table->bigInteger('model_id');
			$table->primary(['role_id','model_id','model_type'], 'model_has_roles_pkey');
			$table->index(['model_id','model_type']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('model_has_roles');
	}

}
