<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Gluten Free',
            'Vegetariano',
            'Vegano',
            'Ricetta dell nonna',
            'Piatto veloce',
            'Mediterranea',
            'Tradizionale',
            'Internazionale'
        ];
            
        foreach($tags as $tag_name) {
            $new_tag = new Tag();
            $new_tag->name = $tag_name;
            $new_tag->slug = Str::slug($new_tag->name, '-');
            $new_tag->save();
        }
    
    }
}
