<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    

    public function art(){

        return $this->belongsTo('\App\Art');

    }


}
