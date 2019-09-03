<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreQuestion extends Model
{
    

    public function choices(){

        return $this->hasMany('\App\Choice', 'question_id');

    }

}
