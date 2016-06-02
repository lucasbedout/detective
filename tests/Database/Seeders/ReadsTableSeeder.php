<?php

namespace Detective\Testing\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Detective\Testing\Models\User;
use Detective\Testing\Models\Post;

class ReadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();

        $users->each(function($user) use ($faker) {
            $posts = Post::where('user_id', '!=', $user->id)->get();
            $posts->each(function($post) use ($faker, $user) {
                // 1 chance on 20 the user read the post
                if (rand(0,20) == 2) {
                    $user->reads()->attach($post->id);
                }
            });
        });
    }
}
