<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;


    public function reportable(){
        
        return $this->morphTo();

    }

    public function user(){

        return $this->belongsTo('\App\User');

    }
}
