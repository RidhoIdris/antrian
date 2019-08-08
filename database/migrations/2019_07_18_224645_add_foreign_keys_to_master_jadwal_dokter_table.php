<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMasterJadwalDokterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('master_jadwal_dokter', function(Blueprint $table)
		{
			$table->foreign('id_dokter', 'fk_master_jadwal_dokter_master_dokter_1')->references('id')->on('master_dokter')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('master_jadwal_dokter', function(Blueprint $table)
		{
			$table->dropForeign('fk_master_jadwal_dokter_master_dokter_1');
		});
	}

}
