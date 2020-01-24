<?php

use Illuminate\Database\Seeder;
use \App\Tag;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ["IELTS", "TOEFL", "GMAT", "SAT", "NBDE"];

        foreach($tags as $tag){
            $exists = Tag::where('name', $tag)->first();
            if(!$exists){
                $newTag = Tag::create(['name' => $tag, 'url' => Str::slug($tag, '-')]);
            }
        }
    }
}
