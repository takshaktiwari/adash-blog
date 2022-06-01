<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Takshak\Ablog\Models\Blog\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    public function run(Faker $faker)
    {
        Storage::disk('public')->deleteDirectory('blog_categories');
        BlogCategory::factory(12)->create();
    }
}
