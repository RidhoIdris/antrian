<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterAsuransiPasien extends Model
{
    protected $guarded = [];
    protected $table = 'master_asuransi_pasien';

    public function master_pasien(){
        return $this->belongsTo('App\MasterPasien','pasien_id');
    }

    public function master_asuransi(){
        return $this->hasMany('App\MasterAsuransi','asuransi_id');
    }

}
