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

    public function art(){
        return $this->belongsTo('\App\Art');
    }

    public function upvotes(){
        return $this->hasMany('\App\Upvote', 'answer_id');
    }

    public function reports()
    {
        return $this->morphMany('\App\Report', 'reportable');
    }

}
