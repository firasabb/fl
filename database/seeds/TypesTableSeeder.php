<?php

use Illuminate\Database\Seeder;
use \App\Type;
use Illuminate\Support\Str;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ["stock photo", "stock video", "sound effects", "music", "logos", "icons", "illustrations"];

        foreach($types as $type){
            $exists = Type::where('name', $type)->first();
            if(!$exists){
                $newType = Type::create(['name' => $type, 'url' => Str::slug($type, '-')]);
            }
        }
    }
}
