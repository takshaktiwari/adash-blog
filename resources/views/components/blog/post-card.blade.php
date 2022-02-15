<div class="card">
	<img class="card-img-top" src="{{ $post->image_md() }}" alt="Card image" class="w-100">
	<div class="card-body">
		<h4 class="card-title lc-2">{{ $post->title }}</h4>
		<p class="card-text lc-3">{{ $post->excerpt() }}</p>
		<a href="{{ route('blog.posts.show', [$post]) }}" class="btn btn-primary">Read More >></a>
	</div>
</div>