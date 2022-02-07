<?php

namespace Database\Seeders;

use Str;
use Storage;
use App\Models\Blog\BlogCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Takshak\Imager\Facades\Picsum;

class BlogCategorySeeder extends Seeder
{
    public function run(Faker $faker)
    {
        Storage::disk('public')->deleteDirectory('blog_categories');
        for ($i=0; $i < 10; $i++) { 
            $category = new BlogCategory;
            $category->name =   $faker->company;
            $category->slug =   \Str::of($category->name)->slug('-');
            $category->blog_category_id  =   ($i > 6) ? BlogCategory::inRandomOrder()->first()?->id : null;

            $fileName = Str::of(microtime())->slug('-').'.jpg';
            $category->image_sm =   'blog_categories/sm/'.$fileName;
            $category->image_md =   'blog_categories/md/'.$fileName;
            $category->image_lg =   'blog_categories/'.$fileName;

            Picsum::dimensions(800, 500)
            ->basePath(Storage::disk('public')->path('/'))
            ->save($category->image_lg)
            ->copy($category->image_md, 400)
            ->copy($category->image_sm, 200);

            $category->status   =   ($i % 5 == 0) ? false : true;
            $category->featured =   ($i % 4 == 0) ? false : true;
            $category->meta_title   =   $faker->realText(rand(100, 250), 2);
            $category->meta_keywords    =   $faker->realText(rand(200, 300), 2);
            $category->meta_description =   $faker->realText(rand(200, 350), 2);

            $category->save();
        }
    }
}
