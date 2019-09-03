<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    

    public function prequestion(){

        return $this->belongsTo('\App\PreQuestion');

    }


}
