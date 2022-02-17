<?php

namespace Takshak\Ablog\View\Components\Blog;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $search = true;
    public $categories = 8;
    public $featuredPosts = 8;
    public $latestPosts = 8;
    public $recentComments = 4;

    public function __construct($search=true, $categories=8, $featuredPosts=8, $latestPosts=8, $recentComments=4)
    {
        $this->search = $search;

        $this->categories = (int)$categories;
        if ($this->categories) {
            $this->categories = BlogCategory::select('id', 'slug', 'name')->limit($this->categories)->get();
        }

        $this->featuredPosts = (int)$featuredPosts;
        if ($this->featuredPosts) {
            $this->featuredPosts = BlogPost::select('id', 'title', 'slug', 'image_sm', 'updated_at')->featured()->active()->limit($this->featuredPosts)->get();
        }

        $this->latestPosts = (int)$latestPosts;
        if ($this->latestPosts) {
            $this->latestPosts = BlogPost::select('id', 'title', 'slug', 'image_sm', 'updated_at')->active()->latest()->limit($this->latestPosts)->get();
        }

        $this->recentComments = (int)$recentComments;
        if ($this->recentComments) {
            $this->recentComments = BlogComment::select('id', 'name', 'comment', 'created_at')->latest()->limit($this->recentComments)->get();
        }
    }
    
    public function render()
    {
    	return View::first(['components.blog.sidebar', 'ablog::components.blog.sidebar']);
    }
}