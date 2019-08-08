<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbAntrianTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_antrian', function(Blueprint $table)
		{
			$table->foreign('id_dokter', 'fk_tb_antrian_master_dokter_1')->references('id')->on('master_dokter')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_pasien', 'fk_tb_antrian_master_pasien_1')->references('id')->on('master_pasien')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_antrian', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_antrian_master_dokter_1');
			$table->dropForeign('fk_tb_antrian_master_pasien_1');
		});
	}

}
