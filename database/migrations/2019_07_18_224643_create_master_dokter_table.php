<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMasterDokterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_dokter', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nama_dokter')->nullable();
			$table->integer('id_spesialis')->nullable();
			$table->timestamps();
			$table->string('foto')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('master_dokter');
	}

}
