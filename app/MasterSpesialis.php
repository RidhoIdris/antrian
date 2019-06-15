<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSpesialis extends Model
{
    protected $guarded = [];
    protected $table = 'master_spesialis';

    public function master_dokter(){
        return $this->hasMany('App\MasterDokter','master_dokter','id_dokter');
    }

}
