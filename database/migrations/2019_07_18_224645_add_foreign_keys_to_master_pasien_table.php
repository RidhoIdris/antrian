<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMasterPasienTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('master_pasien', function(Blueprint $table)
		{
			$table->foreign('id_tipe_pembayaran', 'fk_master_pasien_master_tipe_pembayaran_1')->references('id')->on('master_tipe_pembayaran')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('id_user', 'fk_master_pasien_users_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('master_pasien', function(Blueprint $table)
		{
			$table->dropForeign('fk_master_pasien_master_tipe_pembayaran_1');
			$table->dropForeign('fk_master_pasien_users_1');
		});
	}

}
