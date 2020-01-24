<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cover extends Model
{
    
    public function preart(){
        return $this->belongsTo('\App\PreArt', 'preart_id');
    }

    public function art(){
        return $this->belongsTo('\App\Art');
    }
}
