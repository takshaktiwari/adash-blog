<?php

namespace Takshak\Ablog\Traits\Controllers;

use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;

trait BlogCommentTrait{

	public function store(Request $request, BlogPost $post)
	{
		$request->validate([
			'name'	=>	'required',
			'email'	=>	'required|email',
			'comment'			=>	'required|max:500',
			'blog_comment_id'	=>	'nullable|numeric',
			'reply_to_name'		=>	'nullable|string',
		]);

		BlogComment::create([
			'blog_post_id'		=>	$post->id,
			'user_id'			=>	auth()->id(),
			'blog_comment_id'	=>	$request->post('blog_comment_id'),
			'reply_to_name'	=>	$request->post('reply_to_name'),
			'name'			=>	$request->post('name'),
			'email'			=>	$request->post('email'),
			'comment'		=>	$request->post('comment'),
		]);

		return redirect()->route('blog.posts.show', [$post])->withTitle('Your comment is posted.')->withSuccess('SUCCESS !! Your comment has been successfully stored.');
	}

}
