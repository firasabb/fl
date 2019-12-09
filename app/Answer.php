<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{

    use SoftDeletes;

    public function user(){
        return $this->belongsTo('\App\User');
    }

    public function question(){
        return $this->belongsTo('\App\Question');
    }

    public function upvotes(){
        return $this->hasMany('\App\Upvote', 'answer_id');
    }

    public function reports()
    {
        return $this->morphMany('\App\Report', 'reportable');
    }

}
