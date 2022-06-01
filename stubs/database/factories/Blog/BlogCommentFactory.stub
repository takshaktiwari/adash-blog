<?php

namespace Database\Factories\Blog;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Takshak\Ablog\Models\Blog\BlogComment;
use Takshak\Ablog\Models\Blog\BlogPost;

class BlogCommentFactory extends Factory
{
    protected $model = BlogComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'blog_post_id'      =>  BlogPost::inRandomOrder()->first()->id,
            'user_id'           =>  User::inRandomOrder()->first()->id,
            'blog_comment_id'   =>  BlogComment::inRandomOrder()->first()?->id,
            'name'      =>  $this->faker->name(),
            'email'     =>  $this->faker->email(),
            'comment'   =>  $this->faker->realText(rand(100, 300), 2),
        ];
    }
}
