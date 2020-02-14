<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function contest(){
        return $this->belongsTo('\App\Contest');
    }
}
