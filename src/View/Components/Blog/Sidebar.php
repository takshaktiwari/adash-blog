<?php

namespace Takshak\Ablog\View\Components\Blog;
use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Sidebar extends Component
{
    public $search = false;
    public $categories = false;
    public $featured_posts = false;
    public $latest_posts = false;

    public function __construct($search=false, $categories=false, $featured_posts=false, $latest_posts=false)
    {
        $this->search       = $search;
        $this->categories   = $categories;
        $this->featured_posts   = $featured_posts;
        $this->latest_posts     = $latest_posts;
    }
    
    public function render()
    {
    	return View::first(['components.blog.sidebar', 'alertt::components.blog.sidebar']);
    }
}