<?php

namespace Takshak\Ablog\Traits\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;

trait BlogPostTrait
{

    public function index(Request $request)
    {
        $query = BlogPost::active();
        if ($request->get('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->get('search') . '%');
                $query->orWhere('slug', 'LIKE', '%' . $request->get('search') . '%');
                $query->orWhere('content', 'LIKE', '%' . $request->get('search') . '%');
                $query->orWhereHas('categories', function ($query) use ($request) {
                    $query->where('blog_categories.name', 'LIKE', '%' . $request->get('search') . '%');
                    $query->orWhere('blog_categories.slug', 'LIKE', '%' . $request->get('search') . '%');
                });
            });
        }

        if ($request->get('category')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('name', $request->get('category'));
                $query->orWhere('blog_categories.id', $request->get('category'));
                $query->orWhere('blog_categories.slug', $request->get('category'));
            });
        }

        $posts = $query->latest()->paginate(10);

        return View::first(
            ['blog.posts.index', 'ablog::blog.posts.index'],
            compact('posts')
        );
    }

    public function show(BlogPost $post)
    {
        abort_if(!$post->status, 404);
        $post->load('user:id,name')
            ->load('categories:id,name,slug')
            ->load(['comments' => function ($query) {
                $query->select('id', 'name', 'blog_post_id', 'name', 'comment', 'reply_to_name', 'created_at');
                $query->head();
                $query->with(['children' => function ($query) {
                    $query->select('id', 'name', 'blog_comment_id', 'comment', 'reply_to_name', 'created_at');
                    $query->with('parent:id,blog_comment_id,name');
                }]);
            }]);

        $nextPost = BlogPost::select('id', 'title', 'slug')
            ->where('id', '>', $post->id)
            ->active()
            ->orderBy('id', 'ASC')->first();

        $prevPost = BlogPost::select('id', 'title', 'slug')
            ->where('id', '<', $post->id)
            ->active()
            ->orderBy('id', 'DESC')->first();

        return View::first(
            ['blog.posts.show', 'ablog::blog.posts.show'],
            compact('post', 'nextPost', 'prevPost')
        );
    }
}
