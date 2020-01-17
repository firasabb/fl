<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    

    public function art(){

        return $this->belongsTo('\App\Art');

    }


}
