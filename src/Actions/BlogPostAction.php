<?php

namespace Takshak\Ablog\Actions;

use Str;
use Takshak\Imager\Facades\Imager;

class BlogPostAction
{
	public function save($request, $post)
	{
		$post->title    = $request->post('title');
		$post->slug     = Str::of($post->title.'-'.rand(1, 99))->slug('-');
		$post->status   = $request->post('status');
		$post->featured = $request->post('featured');
		$post->commentable  = $request->post('commentable');
		$post->content      = $request->post('content');
		$post->m_title      = $request->post('m_title');
		$post->m_keywords   = $request->post('m_keywords');
		$post->m_description    = $request->post('m_description');
		$post->user_id 			= auth()->id();

		if ($request->file('thumbnail')){
		    $imageName = $post->slug.'.'.$request->file('thumbnail')->extension();
		    $post->image_sm = 'blog_posts/sm/'.$imageName;
		    $post->image_md = 'blog_posts/md/'.$imageName;
		    $post->image_lg = 'blog_posts/'.$imageName;

		    Imager::init($request->file('thumbnail'))
		        ->resizeFit(800, 500)->inCanvas('#fff')
		        ->basePath(\Storage::disk('public')->path('/'))
		        ->save($post->image_lg)
		        ->save($post->image_md, 400)
		        ->save($post->image_sm, 200);
		}
		$post->save();

		return $post;
	}
}