<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterDokter extends Model
{
    protected $guarded = [];
    protected $table = 'master_dokter';

    public function master_spesialis(){
        return $this->belongsTo('App\MasterSpesialis','id_spesialis');
    }
    public function jadwal_dokter(){
        return $this->hasMany('App\JadwalDokter','master_jadwal_dokter','id_dokter');
    }
}
