<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $guarded=[];
    protected $table='master_jadwal_dokter';

    public function master_dokter(){
        return $this->belongsTo('App\MasterDokter','id_dokter');
    }

}
