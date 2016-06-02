<?php

namespace Detective\Testing\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Detective\Testing\Models\User;
use Detective\Testing\Models\Post;

class PostsTableSeeder extends Seeder
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
            $range = collect(range(0, rand(0, 10)));
            $range->each(function($index) use ($user, $faker) {
                $user->posts()->save(new Post([
                    'title' => $faker->sentence(),
                    'content' => $faker->paragraph(rand(4, 15)),
                    'user_id' => $user->id
                ]));
            });
        });
    }
}
