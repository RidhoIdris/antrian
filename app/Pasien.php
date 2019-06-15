<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $guarded = [];
    protected $table = 'master_pasien';

    public function user(){
        return $this->belongsTo('App\User','id_user');
    }
}
