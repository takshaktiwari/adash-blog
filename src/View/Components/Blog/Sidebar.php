<?php

namespace Takshak\Ablog\View\Components\Blog;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;
use Takshak\Ablog\Models\Blog\BlogCategory;
use Takshak\Ablog\Models\Blog\BlogComment;
use Takshak\Ablog\Models\Blog\BlogPost;

class Sidebar extends Component
{
    public $search = true;
    public $categories = 8;
    public $featuredPosts = 8;
    public $latestPosts = 8;
    public $recentComments = 4;
    public $featuredCategories = [];
    public $latestCategories = [];

    public function __construct($search = true, $categories = 8, $featuredCategories = [], $featuredPosts = 8, $latestCategories = [], $latestPosts = 8, $recentComments = 4)
    {
        $this->search = $search;
        $this->featuredCategories = $featuredCategories;
        $this->latestCategories = $latestCategories;

        $this->categories = (int)$categories;
        if ($this->categories) {
            $this->categories = BlogCategory::query()
                ->select('id', 'slug', 'name')
                ->with(['children' => fn($q) => $q->where('status', true)])
                ->where('status', true)
                ->parent()
                ->limit($this->categories)
                ->get();
        }

        $this->featuredPosts = (int)$featuredPosts;
        if ($this->featuredPosts) {
            $this->featuredPosts = BlogPost::query()
                ->select('id', 'title', 'slug', 'image_sm', 'updated_at', 'created_at')
                ->when(count($this->featuredCategories), function ($query) {
                    $query->whereHas('categories', function ($query) {
                        $query->whereIn('blog_categories.id', $this->featuredCategories);
                    });
                })
                ->featured()
                ->active()
                ->limit($this->featuredPosts)
                ->get();
        }

        $this->latestPosts = (int)$latestPosts;
        if ($this->latestPosts) {
            $this->latestPosts = BlogPost::query()
                ->select('id', 'title', 'slug', 'image_sm', 'updated_at', 'created_at')
                ->when(count($this->latestCategories), function ($query) {
                    $query->whereHas('categories', function ($query) {
                        $query->whereIn('blog_categories.id', $this->latestCategories);
                    });
                })
                ->active()
                ->latest()
                ->limit($this->latestPosts)
                ->get();
        }

        $this->recentComments = (int)$recentComments;
        if ($this->recentComments) {
            $this->recentComments = BlogComment::query()
                ->select('id', 'blog_post_id', 'name', 'comment', 'created_at')
                ->with('post:id,slug')
                ->whereRelation('post', 'status', true)
                ->latest()
                ->limit($this->recentComments)
                ->get();
        }
    }

    public function render()
    {
        return View::first(['components.blog.sidebar', 'ablog::components.blog.sidebar']);
    }
}
