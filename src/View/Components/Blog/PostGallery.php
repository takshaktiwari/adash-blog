<?php

namespace Takshak\Ablog\View\Components\Blog;
use Illuminate\View\Component;

class PostGallery extends Component
{
    public function render()
    {
        return View::first(['components.blog.post-gallery', 'alertt::components.blog.post-gallery']);
    }
}