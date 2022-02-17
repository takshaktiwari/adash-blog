<?php

namespace Takshak\Ablog\Traits\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;

trait PostTrait{

	public function index(Request $request)
	{
		$query = BlogPost::active();
		if ($request->get('search')) {
			$query->where(function($query) use($request){
				$query->where('title', 'LIKE', '%'.$request->get('search').'%');
				$query->orWhere('slug', 'LIKE', '%'.$request->get('search').'%');
				$query->orWhere('content', 'LIKE', '%'.$request->get('search').'%');
				$query->orWhereHas('categories', function($query) use($request){
					$query->where('categories.name', 'LIKE', '%'.$request->get('search').'%');
					$query->orWhere('categories.slug', 'LIKE', '%'.$request->get('search').'%');
				});
			});
		}

		if ($request->get('category')) {
			$query->whereHas('categories', function($query) use($request){
				$query->where('name', $request->get('category'));
				$query->orWhere('blog_categories.id', $request->get('category'));
				$query->orWhere('blog_categories.slug', $request->get('category'));
			});
		}

		$posts = $query->paginate(10);

		return View::first(
			['blog.posts.index', 'ablog::blog.posts.index'], 
			compact('posts')
		);
	}

	public function show(BlogPost $post)
	{
		$post->load('user:id,name')
		->load('categories:id,name,slug')
		->load(['comments' => function($query){
			$query->select('id', 'name', 'blog_post_id', 'name', 'comment', 'created_at');
			$query->head()->with(['children' => function($query){
				$query->select('id', 'name', 'blog_comment_id', 'comment', 'created_at');
				$query->with('parent:id,blog_comment_id,name');
				$query->with(['children' => function($query){
					$query->select('id', 'name', 'blog_comment_id', 'comment', 'created_at');
					$query->with('parent:id,blog_comment_id,name');
					$query->with(['children' => function($query){
						$query->select('id', 'name', 'blog_comment_id', 'comment', 'created_at');
						$query->with('parent:id,blog_comment_id,name');
					}]);
				}]);
			}]);
		}]);

		$nextPost = BlogPost::select('id', 'title', 'slug')
		->where('id', '>', $post->id)
		->orderBy('id', 'ASC')->first();

		$prevPost = BlogPost::select('id', 'title', 'slug')
		->where('id', '<', $post->id)
		->orderBy('id', 'DESC')->first();

		return View::first(
			['blog.posts.show', 'ablog::blog.posts.show'], 
			compact('post', 'nextPost', 'prevPost')
		);
	}
}