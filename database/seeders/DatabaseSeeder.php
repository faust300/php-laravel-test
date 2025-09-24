<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()
            ->count(5)
            ->create()
            ->each(function ($post) {
                Comment::factory()->count(3)->create([
                    'post_id' => $post->id,
                ]);
            });
    }
}