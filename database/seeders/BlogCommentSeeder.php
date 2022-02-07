<?php

namespace Database\Seeders;

use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class BlogCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $posts = BlogPost::pluck('id');
        $users = User::pluck('id');

        for ($i=0; $i < 400; $i++) { 
            $comment = new BlogComment;

            $comment->blog_post_id   =   $posts->shuffle()->first();
            $comment->user_id   =   $users->shuffle()->first();
            $comment->blog_comment_id   =   ($i % 6 == 0) ? BlogComment::inRandomOrder()->first()?->id : null;
            $comment->name  =   $faker->name;
            $comment->email     =   $faker->email;
            $comment->comment   =   $faker->realText(rand(100, 300), 2);
            $comment->save();
        }
    }
}
