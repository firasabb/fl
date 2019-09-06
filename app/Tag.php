<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function questions()
    {
        return $this->morphedByMany('App\Question', 'taggable');
    }

    public function prequestions()
    {
        return $this->morphedByMany('App\PreQuestion', 'taggable');
    }
}
