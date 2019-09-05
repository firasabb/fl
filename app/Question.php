<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    

    public function choices(){

        return $this->hasMany('\App\Choice', 'question_id');

    }



}
