<?php

namespace Database\Factories\Blog;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Takshak\Ablog\Models\Blog\BlogPost;
use Takshak\Imager\Facades\Picsum;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title  = $this->faker->realText(rand(100, 200), 2);
        $slug   = Str::of($title)->slug('-');

        $fileName = Str::of(microtime())->slug('-') . '.jpg';
        $image_sm = 'blog_posts/sm/' . $fileName;
        $image_md = 'blog_posts/md/' . $fileName;
        $image_lg = 'blog_posts/' . $fileName;

        Picsum::dimensions(800, 500)
            ->save(Storage::disk('public')->path($image_lg))
            ->save(Storage::disk('public')->path($image_md), 400)
            ->save(Storage::disk('public')->path($image_sm), 200)
            ->destroy();

        return [
            'title'     =>  $title,
            'slug'      =>  $slug,
            'image_sm'  =>  $image_sm,
            'image_md'  =>  $image_md,
            'image_lg'  =>  $image_lg,
            'status'    =>  rand(0, 1),
            'featured'  =>  rand(0, 1),
            'commentable'   =>  rand(0, 1),
            'content'   =>  $this->faker->realText(rand(500, 2000), 2),
            'm_title'       =>  $this->faker->realText(rand(100, 200), 2),
            'm_keywords'    =>  $this->faker->realText(rand(100, 250), 2),
            'm_description' =>  $this->faker->realText(rand(100, 300), 2),
            'user_id'   =>  User::inRandomOrder()->first()?->id,
        ];
    }
}
