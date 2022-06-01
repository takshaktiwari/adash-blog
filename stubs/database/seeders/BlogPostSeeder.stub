<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Takshak\Ablog\Models\Blog\BlogCategory;
use Takshak\Ablog\Models\Blog\BlogComment;
use Takshak\Ablog\Models\Blog\BlogPost;

class BlogPostSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        Storage::disk('public')->deleteDirectory('blog_posts');

        BlogPost::factory(100)
            ->create()
            ->each(function ($post) {
                $postCategories = BlogCategory::inRandomOrder()->pluck('id');
                $post->categories()->sync($postCategories->take(rand(2, 4))->toArray());

                BlogComment::factory(rand(0, 12))->create();
            });
    }
}
