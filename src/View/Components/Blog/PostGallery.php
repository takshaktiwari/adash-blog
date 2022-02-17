<?php

namespace Takshak\Ablog\View\Components\Blog;
use App\Models\Blog\BlogPost;
use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class PostGallery extends Component
{
    public $type; // latest, featured
    public $limit;
    public $orderBy;
    public $posts;
    public function __construct($type='latest', $limit='6', $orderBy='random')
    {
        $this->type     = $type;
        $this->limit    = $limit;
        $this->orderBy    = $orderBy;

        $query = BlogPost::active();

        if ($this->type == 'featured') {
            $query->featured();
        }
        if ($this->orderBy == 'random') {
            $query->inRandomOrder();
        }elseif($this->orderBy == 'latest'){
            $query->latest();
        }elseif($this->orderBy == 'oldest'){
            $query->oldest();
        }

        $this->posts = $query->limit($limit)->get();
    }

    public function render()
    {
        return View::first(['components.blog.post-gallery', 'ablog::components.blog.post-gallery']);
    }
}