<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMasterPasienTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_pasien', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nama_lengkap')->nullable();
			$table->string('nama_panggilan')->nullable();
			$table->string('jenis_kelamin', 50)->nullable();
			$table->date('tanggal_lahir')->nullable();
			$table->string('no_identitas', 50)->nullable();
			$table->string('agama', 50)->nullable();
			$table->string('pendidikan', 150)->nullable();
			$table->string('no_hp', 14)->nullable();
			$table->string('alamat')->nullable();
			$table->integer('id_tipe_pembayaran')->nullable();
			$table->timestamps();
			$table->string('foto')->nullable();
			$table->integer('id_user');
			$table->string('nama_pj')->nullable();
			$table->text('alamat_pj')->nullable();
			$table->string('no_hp_pj', 13)->nullable();
			$table->string('hubungan')->nullable();
			$table->string('avatar')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('master_pasien');
	}

}
