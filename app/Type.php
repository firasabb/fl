<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    public function prearts(){
        return $this->hasMany('\App\PreArt');
    }

    public function arts(){
        return $this->hasMany('\App\Art');
    }


}
