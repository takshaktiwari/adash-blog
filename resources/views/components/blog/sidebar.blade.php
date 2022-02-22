@if($search)
<form action="{{ route('blog.posts.index') }}" class="card mb-4">
	<div class="card-header">
		<h5 class="m-0"><i class="fa-solid fa-magnifying-glass"></i> Search Here</h5>
	</div>
	<div class="card-body">
		<div class="input-group">
			<input type="text" name="search" class="form-control" value="{{ request()->get('search') }}" placeholder="Search Here..">
			<button type="submit" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
		</div>
	</div>
</form>
@endif

@if($categories && $categories->count())
<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0"><i class="fa-solid fa-tags"></i> Post Categories</h5>
	</div>
	<div class="card-body">
		<ul class="mb-0">
			@foreach($categories as $category)
				<a href="{{ route('blog.posts.index', ['category' => $category->slug]) }}" class="text-decoration-none">
					<li class="py-1">{{ $category->name }}</li>
				</a>
			@endforeach
		</ul>
	</div>
</div>
@endif

@if($featuredPosts && $featuredPosts->count())
<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0"><i class="fa-regular fa-file-lines"></i> Featured Posts</h5>
	</div>
	<div class="card-body">
		@foreach($featuredPosts as $post)
		<div class="row mb-3">
			<div class="col-3 my-auto">
				<a href="{{ route('blog.posts.show', [$post]) }}">
					<img src="{{ $post->image_sm() }}" alt="Featured post image" class="rounded w-100">
				</a>
			</div>
			<div class="col-9 my-auto">
				<a href="{{ route('blog.posts.show', [$post]) }}" class="text-decoration-none lc-1">{{ $post->title }}</a>
				<p class="mb-0 text-secondary small">
					<span class="small">{{ $post->updated_at->format('D, d-M-Y H:i') }}</span>
				</p>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endif

@if($latestPosts && $latestPosts->count())
<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0"><i class="fa-regular fa-file-lines"></i> Latest Posts</h5>
	</div>
	<div class="card-body">
		@foreach($latestPosts as $post)
		<div class="row mb-3">
			<div class="col-3 my-auto">
				<a href="{{ route('blog.posts.show', [$post]) }}">
					<img src="{{ $post->image_sm() }}" alt="Featured post image" class="rounded w-100">
				</a>
			</div>
			<div class="col-9 my-auto">
				<a href="{{ route('blog.posts.show', [$post]) }}" class="text-decoration-none lc-1">{{ $post->title }}</a>
				<p class="mb-0 text-secondary small">
					<span class="small">{{ $post->updated_at->format('D, d-M-Y H:i') }}</span>
				</p>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endif

@if($recentComments && $recentComments->count())
<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0"><i class="fa-regular fa-comments"></i> Recent Comments</h5>
	</div>
	<div class="card-body">
		@foreach($recentComments as $comment)
			<div class="mb-3">
				<a href="{{ route('blog.posts.show', [$comment->post, '#'.strtotime($comment->created_at)]) }}" class="mb-1 lc-2 text-decoration-none">
					<i class="fas fa-quote-left"></i>
					{{ $comment->comment }}
				</a>
				<span class="small">
					<i class="fas fa-user"></i>
					<b>Admin Tiwari:</b>
					<span class="text-secondary small">{{ now() }}</span>
				</span>
			</div>
		@endforeach
	</div>
</div>
@endif
