<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreChoice extends Model
{
    
    public function question(){

        return $this->belongsTo('\App\PreQuestion');
        
    }

}
