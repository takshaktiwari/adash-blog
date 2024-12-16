<?php

namespace Takshak\Ablog\View\Components\Blog;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;
use Takshak\Ablog\Models\Blog\BlogCategory;
use Takshak\Ablog\Models\Blog\BlogComment;
use Takshak\Ablog\Models\Blog\BlogPost;

class Sidebar extends Component
{
    public function __construct(public $search = true, public $categories = 8, public $featuredCategories = [], public $featuredPosts = 8, public $latestCategories = [], public $latestPosts = 8, public $recentComments = 4, public $sectionCategories = [], public $sectionCategoriesPosts = 8)
    {
        $this->latestCategories = $latestCategories;

        if ((int)$this->categories) {
            $this->categories = BlogCategory::query()
                ->select('id', 'slug', 'name')
                ->with(['children' => fn($q) => $q->where('status', true)])
                ->where('status', true)
                ->parent()
                ->limit((int)$this->categories)
                ->get();
        }

        if ((int) $this->recentComments) {
            $this->recentComments = BlogComment::query()
                ->select('id', 'blog_post_id', 'name', 'comment', 'created_at')
                ->with('post:id,slug')
                ->whereRelation('post', 'status', true)
                ->latest()
                ->limit((int)$this->recentComments)
                ->get();
        }

        if ((int)$this->featuredPosts) {
            $this->featuredPosts = $this->getPosts($this->featuredCategories, (int) $this->featuredPosts)->featured()->get();
        }

        if ((int) $this->latestPosts) {
            $this->latestPosts = $this->getPosts($this->latestCategories, (int) $this->latestPosts)->get();
        }

        if (count($this->sectionCategories) && (int)$this->sectionCategoriesPosts) {
            $this->sectionCategories = BlogCategory::query()
                ->select('id', 'slug', 'name')
                ->where(function ($query) {
                    $query->whereIn('blog_categories.id', $this->sectionCategories);
                    $query->orWhereIn('blog_categories.name', $this->sectionCategories);
                    $query->orWhereIn('blog_categories.slug', $this->sectionCategories);
                })
                ->with(['blogPosts' => function ($query) {
                    $query->select('blog_posts.id', 'blog_posts.title', 'blog_posts.slug', 'blog_posts.image_sm', 'blog_posts.updated_at', 'blog_posts.created_at');
                    $query->active();
                    $query->limit((int)$this->sectionCategoriesPosts);
                }])
                ->active()
                ->get();
        }
    }

    public function getPosts($categories = [], $limit = 8)
    {
        return BlogPost::query()
            ->select('id', 'title', 'slug', 'image_sm', 'updated_at', 'created_at')
            ->when(count($categories), function ($query) use ($categories) {
                $query->whereHas('categories', function ($query) use ($categories) {
                    $query->whereIn('blog_categories.id', $categories);
                    $query->orWhereIn('blog_categories.name', $categories);
                    $query->orWhereIn('blog_categories.slug', $categories);
                });
            })
            ->active()
            ->latest()
            ->limit((int) $limit);
    }

    public function render()
    {
        return View::first(['components.blog.sidebar', 'ablog::components.blog.sidebar']);
    }
}
