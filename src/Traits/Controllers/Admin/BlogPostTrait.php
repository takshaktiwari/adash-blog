<?php

namespace Takshak\Ablog\Traits\Controllers\Admin;

use Takshak\Ablog\Actions\BlogPostAction;
use Illuminate\Support\Facades\View;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;

trait BlogPostTrait {

	public function index(Request $request)
	{
		$this->authorize('blog_posts_access');
	    $query = BlogPost::select('id', 'title', 'slug', 'image_sm', 'status', 'featured', 'commentable', 'user_id', 'updated_at', 'created_at')->with('categories:id,name,slug')->with('user:id,name');

	    if ($request->get('search')) {
	        $query->where('title', 'LIKE', '%'.$request->get('search').'%');
	    }
	    if ($request->get('category_id') != null) {
	        $query->whereRelation('categories', 'blog_categories.id', $request->get('category_id'));
	    }
	    if ($request->get('status') != null) {
	        $query->where('status', $request->get('status'));
	    }
	    if ($request->get('featured') != null) {
	        $query->where('featured', $request->get('featured'));
	    }

	    $posts = $query->latest()->paginate(50);

	    $categories = collect();
	    if ($request->get('filter')) {
	        $categories = BlogCategory::select('id', 'name', 'slug', 'blog_category_id')
	        ->with('parentCategory:id,name,slug,blog_category_id')
	        ->orderBy('name')->get();
	    }
	    return View::first([
	    	'admin.blog.posts.index', 'ablog::admin.blog.posts.index'
	    ], compact('posts', 'categories'));
	}

	public function create()
	{
		$this->authorize('blog_posts_create');
	    $categories = BlogCategory::select('id', 'name', 'slug', 'blog_category_id')
	    ->with('parentCategory:id,name,slug,blog_category_id')
	    ->orderBy('name')->get();
	    return View::first([
	    	'admin.blog.posts.create', 'ablog::admin.blog.posts.create'
	    ], compact('categories'));
	}

	public function store(Request $request, BlogPostAction $action)
	{
		$this->authorize('blog_posts_create');
	    $request->validate([
	        'title'         =>  'required',
	        'status'        =>  'nullable|boolean',
	        'featured'      =>  'nullable|boolean',
	        'category_ids'  =>  'required|array|min:1',
	        'content'       =>  'required',
	        'm_title'    =>  'nullable|max:255'
	    ]);

	    $post = new BlogPost;
	    $post = $action->save($request, $post);
	    return redirect()->route('admin.blog.posts.show', [$post])->withSuccess('SUCCESS !! New Post is successfully created.');
	}

	public function show(BlogPost $post)
	{
		$this->authorize('blog_posts_show');
	    return View::first([
	    	'admin.blog.posts.show', 'adash::admin.blog.posts.show'
	    ], compact('post'));
	}

	public function edit(BlogPost $post)
	{
		$this->authorize('blog_posts_update');
	    $categories = BlogCategory::select('id', 'name', 'slug', 'blog_category_id')
	    ->with('parentCategory:id,name,slug,blog_category_id')
	    ->orderBy('name')->get();
	    return View::first([
	    	'admin.blog.posts.edit', 'adash::admin.blog.posts.edit'
	    ], compact('post', 'categories'));
	}

	public function update(Request $request, BlogPost $post, BlogPostAction $action)
	{
		$this->authorize('blog_posts_update');
	    $request->validate([
	        'title'         =>  'required',
	        'status'        =>  'nullable|boolean',
	        'featured'      =>  'nullable|boolean',
	        'category_ids'  =>  'required|array|min:1',
	        'content'       =>  'required',
	        'm_title'    =>  'nullable|max:255'
	    ]);
	    $post = $action->save($request, $post);
	    return redirect()->route('admin.blog.posts.show', [$post])->withSuccess('SUCCESS !! Post is successfully updated.');
	}

	public function statusToggle(BlogPost $post)
	{
		$this->authorize('blog_posts_update');
	    $post->update([
	        'status' => ($post->status) ? false : true
	    ]);
	    return redirect()->route('admin.blog.posts.index')->withSuccess('SUCCESS !! Posts is successfully updated.');
	}

	public function featuredToggle(BlogPost $post)
	{
		$this->authorize('blog_posts_update');
	    $post->update([
	        'featured' => ($post->featured) ? false : true
	    ]);
	    return redirect()->route('admin.blog.posts.index')->withSuccess('SUCCESS !! Featured posts is successfully updated.');
	}

	public function destroy(BlogPost $post)
	{
		$this->authorize('blog_posts_delete');
	    \Storage::delete([
	        $post->image_sm,
	        $post->image_md,
	        $post->image_lg,
	    ]);

	    $post->delete();
	    return redirect()->route('admin.blog.categories.index')->withSuccess('SUCCESS !! Post is successfully deleted');
	}
	
}