<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreArt extends Model
{

    use SoftDeletes;
    

    public function downloads(){

        return $this->hasMany('\App\PreDownload', 'preart_id');

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

}
