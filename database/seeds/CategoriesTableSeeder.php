<?php

use Illuminate\Database\Seeder;
use \App\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ["Science", "Math", "Dentistry", "English"];

        foreach($categories as $category){
            $exists = Category::where('name', $category)->first();
            if(!$exists){
                $newCategory = Category::create(['name' => $category, 'url' => Str::slug($category, '-')]);
            }
        }
    }
}
