<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMasterJadwalDokterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_jadwal_dokter', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_dokter')->nullable();
			$table->string('hari', 50)->nullable();
			$table->time('jam_mulai')->nullable();
			$table->timestamps();
			$table->time('jam_selesai')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('master_jadwal_dokter');
	}

}
