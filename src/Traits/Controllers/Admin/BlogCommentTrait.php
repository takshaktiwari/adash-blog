<?php

namespace Takshak\Ablog\Traits\Controllers\Admin;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Takshak\Ablog\Models\Blog\BlogComment;

trait BlogCommentTrait
{

    public function index(Request $request)
    {
        $this->authorize('blog_comments_access');
        $query = BlogComment::select('id', 'blog_post_id', 'user_id', 'blog_comment_id', 'name', 'email', 'created_at')
            ->with('post:id,title,slug')
            ->with('user:id,name');
        if ($request->get('search')) {
            $query->where('comment', 'LIKE', '%' . $request->get('search') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('post', function ($query) use ($request) {
                    $query->where('title', 'LIKE', '%' . $request->get('search') . '%');
                    $query->orWhere('slug', 'LIKE', '%' . $request->get('search') . '%');
                    $query->orWhere('id', 'LIKE', '%' . $request->get('search') . '%');
                });
            });
        }
        if ($request->get('user')) {
            $query->where('name', 'LIKE', '%' . $request->get('user') . '%');
            $query->orWhere('email', 'LIKE', '%' . $request->get('user') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->get('user') . '%');
                    $query->orWhere('email', 'LIKE', '%' . $request->get('user') . '%');
                });
            });
        }
        $comments = $query->latest()->paginate(50);

        return View::first(
            ['admin.blog.comments.index', 'ablog::admin.blog.comments.index'],
            compact('comments')
        );
    }

    public function show(BlogComment $comment)
    {
        $this->authorize('blog_comments_show');
        return View::first([
            'admin.blog.comments.show', 'ablog::admin.blog.comments.show'
        ], compact('comment'));
    }

    public function edit(BlogComment $comment)
    {
        $this->authorize('blog_comments_update');
        return View::first([
            'admin.blog.comments.edit', 'ablog::admin.blog.comments.edit'
        ], compact('comment'));
    }

    public function update(Request $request, BlogComment $comment)
    {
        $this->authorize('blog_comments_update');
        $request->validate([
            'name'  =>  'required',
            'email'  =>  'required|email',
            'comment'  =>  'required',
        ]);

        $comment->name = $request->post('name');
        $comment->email = $request->post('email');
        $comment->comment = $request->post('comment');
        $comment->save();

        return to_route('admin.blog.comments.show', [$comment])->withSuccess('SUCCESS !! Comment is successfully updated');
    }

    public function destroy(BlogComment $comment)
    {
        $this->authorize('blog_comments_delete');
        $comment->delete();
        return to_route('admin.blog.comments.index')->withSuccess('SUCCESS !! Blog comment is successfully deleted.');
    }
}
