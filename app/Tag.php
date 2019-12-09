<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model implements Searchable
{

    use SoftDeletes;


    public function getSearchResult(): SearchResult
     {
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name
         );
     }


    public function questions()
    {
        return $this->morphedByMany('App\Question', 'taggable');
    }

    public function prequestions()
    {
        return $this->morphedByMany('App\PreQuestion', 'taggable');
    }
}
