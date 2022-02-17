<?php

namespace Takshak\Ablog\View\Components\Blog;
use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class PostCard extends Component
{
    public function __construct(public $post)
    {

    }
    
    public function render()
    {
    	return View::first(['components.blog.post-card', 'ablog::components.blog.post-card']);
    }
}