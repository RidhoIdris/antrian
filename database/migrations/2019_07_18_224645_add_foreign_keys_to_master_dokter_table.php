<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMasterDokterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('master_dokter', function(Blueprint $table)
		{
			$table->foreign('id_spesialis', 'fk_master_dokter_master_spesialis_1')->references('id')->on('master_spesialis')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('master_dokter', function(Blueprint $table)
		{
			$table->dropForeign('fk_master_dokter_master_spesialis_1');
		});
	}

}
