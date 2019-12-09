<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    public function questions()
    {
        return $this->morphedByMany('App\Question', 'categoriable');
    }

    public function prequestions()
    {
        return $this->morphedByMany('App\PreQuestion', 'categoriable');
    }


}
