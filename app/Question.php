<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    
    use SoftDeletes;


    public function choices(){

        return $this->hasMany('\App\Choice', 'question_id');

    }


    public function user(){

        return $this->belongsTo('\App\User');

    }


    public function tags()
    {
        return $this->morphToMany('\App\Tag', 'taggable');
    }


    public function categories()
    {
        return $this->morphToMany('\App\Category', 'categoriable');
    }

    public function answers()
    {
        return $this->hasMany('\App\Answer', 'question_id');
    }

    public function reports()
    {
        return $this->morphMany('\App\Report', 'reportable');
    }


}
