<?php

namespace Database\Seeders;

use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Takshak\Imager\Facades\Picsum;

class BlogPostSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        \Storage::disk('public')->deleteDirectory('blog_posts');
        $users = User::pluck('id');
        $postCategories = BlogCategory::pluck('id');

        for ($i=0; $i < 60; $i++) { 
            $post = new BlogPost;

            $post->title    = $faker->realText(rand(100, 200), 2);
            $post->slug = \Str::of($post->title)->slug('-');

            $fileName = \Str::of(microtime())->slug('-').'.jpg';
            $post->image_sm = 'blog_posts/sm/'.$fileName;
            $post->image_md = 'blog_posts/md/'.$fileName;
            $post->image_lg = 'blog_posts/'.$fileName;

            Picsum::dimensions(800, 500)
            ->basePath(\Storage::disk('public')->path('/'))
            ->save($post->image_lg)
            ->copy($post->image_md, 400)
            ->copy($post->image_sm, 200);

            $post->status   = ($i % 5 == 0) ? false : true;
            $post->featured = ($i % 4 == 0) ? false : true;
            $post->commentable  = rand(0, 1);

            $post->content  = $faker->realText(rand(500, 2000), 2);
            $post->m_title  = $faker->realText(rand(100, 200), 2);
            $post->m_keywords   = $faker->realText(rand(100, 250), 2);
            $post->m_description    = $faker->realText(rand(100, 300), 2);

            $post->user_id  = $users->shuffle()->first();
            $post->save();

            $post->categories()->sync(
                $postCategories->shuffle()->take(rand(2, 5))->toArray()
            );
        }
    }
}
