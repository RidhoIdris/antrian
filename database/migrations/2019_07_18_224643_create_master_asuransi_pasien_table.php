<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMasterAsuransiPasienTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_asuransi_pasien', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->integer('asuransi_id');
			$table->integer('pasien_id');
			$table->string('foto_asuransi');
			$table->timestamps();
			$table->string('no_asuransi')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('master_asuransi_pasien');
	}

}
