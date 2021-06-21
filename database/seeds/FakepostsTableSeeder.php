<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
// Da usare sia Str che Faker ovviamente
use Illuminate\Support\Str;
// E chiaramente anche il Model
use App\Fakepost;

class FakepostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++) {
            $new_post = new Fakepost();
            $new_post->title = $faker->sentence(3);
            $new_post->content = $faker->paragraphs(2, true);
            $new_post->author = $faker->name('female');
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->save();
        }
    }
}
