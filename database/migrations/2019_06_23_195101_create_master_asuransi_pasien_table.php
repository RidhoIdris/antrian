<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterAsuransiPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_asuransi_pasien', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('asuransi_id');
            $table->integer('pasien_id');
            $table->string('foto_asuransi');
            $table->string('no_asuransi');
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('master_pasien');
            $table->foreign('asuransi_id')->references('id')->on('master_asuransi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_asuransi_pasien');
    }
}
