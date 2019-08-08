<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMasterAsuransiPasienTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('master_asuransi_pasien', function(Blueprint $table)
		{
			$table->foreign('pasien_id')->references('id')->on('master_pasien')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('asuransi_id')->references('id')->on('master_asuransi')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('master_asuransi_pasien', function(Blueprint $table)
		{
			$table->dropForeign('master_asuransi_pasien_pasien_id_foreign');
			$table->dropForeign('master_asuransi_pasien_asuransi_id_foreign');
		});
	}

}
