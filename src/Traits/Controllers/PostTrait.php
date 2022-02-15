<?php

namespace Takshak\Ablog\Traits\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;

trait PostTrait{

	public function index(Request $request)
	{
		$posts = BlogPost::paginate(12);

		return View::first(
			['blog.posts.index', 'ablog::blog.posts.index'], 
			compact('posts')
		);
	}

	public function show(BlogPost $post)
	{
		return View::first(
			['blog.posts.show', 'ablog::blog.posts.show'], 
			compact('post')
		);
	}

}