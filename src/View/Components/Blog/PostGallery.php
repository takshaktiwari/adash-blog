<?php

namespace Takshak\Ablog\View\Components\Blog;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;
use Takshak\Ablog\Models\Blog\BlogPost;

class PostGallery extends Component
{
    public $type; // latest, featured
    public $limit;
    public $orderBy;
    public $posts;
    public $categories;
    public function __construct($type = 'latest', $limit = '6', $orderBy = 'random', $posts = null, $categories = [])
    {
        $this->type     = $type;
        $this->limit    = $limit;
        $this->orderBy    = $orderBy;
        $this->categories    = $categories;

        if ($posts) {
            $this->posts = $posts;
        } else {
            $query = BlogPost::active()
                ->when(count($this->categories), function ($query) {
                    $query->whereHas('categories', function ($query) {
                        $query->whereIn('blog_categories.id', $this->categories);
                        $query->orWhereIn('blog_categories.name', $this->categories);
                        $query->orWhereIn('blog_categories.slug', $this->categories);
                    });
                });

            if ($this->type == 'featured') {
                $query->featured();
            }
            if ($this->orderBy == 'random') {
                $query->inRandomOrder();
            } elseif ($this->orderBy == 'latest') {
                $query->latest();
            } elseif ($this->orderBy == 'oldest') {
                $query->oldest();
            }

            $this->posts = $query->limit($limit)->get();
        }
    }

    public function render()
    {
        return View::first(['components.blog.post-gallery', 'ablog::components.blog.post-gallery']);
    }
}
