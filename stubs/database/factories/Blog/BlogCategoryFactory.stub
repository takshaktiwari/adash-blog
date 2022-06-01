<?php

namespace Database\Factories\Blog;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Takshak\Ablog\Models\Blog\BlogCategory;
use Takshak\Imager\Facades\Picsum;

class BlogCategoryFactory extends Factory
{
    protected $model = BlogCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name =   $this->faker->company();
        $slug =   Str::of($name)->slug('-');

        $fileName = Str::of(microtime())->slug('-') . '.jpg';
        $image_sm =   'blog_categories/sm/' . $fileName;
        $image_md =   'blog_categories/md/' . $fileName;
        $image_lg =   'blog_categories/' . $fileName;

        Picsum::dimensions(800, 500)
            ->save(Storage::disk('public')->path($image_lg))
            ->save(Storage::disk('public')->path($image_md), 400)
            ->save(Storage::disk('public')->path($image_sm), 200)
            ->destroy();

        return [
            'name'  =>  $name,
            'slug'  =>  $slug,
            'blog_category_id'  =>  BlogCategory::inRandomOrder()->first()?->id,
            'image_sm'  =>  $image_sm,
            'image_md'  =>  $image_md,
            'image_lg'  =>  $image_lg,
            'status'    =>  rand(0, 1),
            'featured'  =>  rand(0, 1),
            'meta_title'    =>  $this->faker->realText(rand(100, 250), 2),
            'meta_keywords' =>  $this->faker->realText(rand(200, 300), 2),
            'meta_description'  =>  $this->faker->realText(rand(200, 350), 2),
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => true,
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => false,
            ];
        });
    }
}
