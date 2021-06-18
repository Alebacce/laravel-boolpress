<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
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
            $new_post->content = $faker-> $faker->paragraphs(2, true);
            $new_post->author = $faker->name($gender = null|'male'|'female');
            $new_post->save();
        }
    }
}
