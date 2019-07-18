<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbAntrianTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_antrian', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_dokter')->nullable();
			$table->integer('id_pasien')->nullable();
			$table->timestamps();
			$table->integer('no_antrian')->nullable();
			$table->time('jam')->nullable();
			$table->string('hari')->nullable();
			$table->string('tipe_pembayaran')->nullable();
			$table->string('status', 15)->nullable();
			$table->integer('id_asuransi')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_antrian');
	}

}
