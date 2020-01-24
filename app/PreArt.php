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

    public function type(){
        return $this->belongsTo('\App\Type');
    }

    public function tags()
    {
        return $this->morphToMany('\App\Tag', 'taggable');
    }

    public function categories()
    {
        return $this->morphToMany('\App\Category', 'categoriable');
    }

    public function covers(){
        return $this->hasMany('\App\Cover', 'preart_id');
    }

}
