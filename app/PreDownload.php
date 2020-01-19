<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreDownload extends Model
{
    
    public function preart(){

        return $this->belongsTo('\App\PreArt');
        
    }

}
