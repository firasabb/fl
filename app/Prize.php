<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    
    
    public function contest(){

        return $this->belongsTo('\App\Contest');

    }


    
    public function winner(){

        return $this->belongsTo('\App\User');

    }

}
