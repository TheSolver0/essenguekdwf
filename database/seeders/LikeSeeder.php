<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Post::all()->each(function ($post) use ($users) {
            $users->random(rand(1, 5))->each(function ($user) use ($post) {
                Like::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            });
        });

    }
}
