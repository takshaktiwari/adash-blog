<x-app-layout>
	<x-breadcrumb 
		:title="'Post: '.$post->title" 
		:links="[
			['text' => 'Blog Posts', 'url' => route('blog.posts.index')],
			['text' => 'Post']
		]" />

	<div class="container py-5">
		<div class="row">
			<div class="col-lg-8">
				<div class="card mb-4">
					<img class="card-img-top" src="{{ $post->image_lg() }}" alt="Card image" width="w-100">
					<div class="card-body">
						<h4 class="card-title">{{ $post->title }}</h4>
						<div class="d-flex flex-wrap small">
							<span class="author">By {{ $post->user->name }}</span>
							<span class="px-1 text-dark">|</span>
							<span class="updated_dat">{{ $post->updated_at->format('D, d-M-Y H:i') }}</span>
						</div>
					</div>
					<div class="card-body border-top">
						{{ $post->content }}
					</div>
				</div>

				<div class="next-prev-post mb-4">
					<div class="row">
						<div class="col-md-6">
							@if($prevPost)
							<div class="card prev-post bg-light">
								<div class="card-body d-flex">
									<a href="{{ route('blog.posts.show', [$prevPost]) }}" class="display-6 me-3 my-auto">
										<i class="fas fa-arrow-left"></i>
									</a>
									<div class="my-auto">
										<h6 class="lc-2 mb-0">{{ $prevPost->title }}</h6>
										<span class="text-secondary small">Previous Post</span>
									</div>
								</div>
							</div>
							@endif
						</div>
						<div class="col-md-6">
							@if($nextPost)
							<div class="card next-post bg-light">
								<div class="card-body d-flex">
									<div class="my-auto text-end me-3">
										<h6 class="lc-2 mb-0">{{ $nextPost->title }}</h6>
										<span class="text-secondary small">Next Post</span>
									</div>
									<a href="{{ route('blog.posts.show', [$nextPost]) }}" class="display-6 my-auto">
										<i class="fas fa-arrow-right"></i>
									</a>
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
				

				<div class="comments mb-5">
					<h3>Comments </h3>
					@foreach($post->comments as $comment)
					<div class="card mb-3">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-2 col-3 text-center">
									<img src="{{ route('imgr.placeholder', ['w' => 80, 'h' => 80, 'text' => substr($comment->name, 0, 2)]) }}" alt="image" class="rounded-circle w-100">
								</div>
								<div class="col-lg-10 col-9 my-auto">
									<p class="mb-0 fw-bold">{{ $comment->name }}</p>
									<p class="mb-1 small fw-normal text-secondary">
										<span class="small">{{ $comment->created_at->format('D, d-M-Y H:i') }}</span>
									</p>
									<p class="mb-0 small">{{ $comment->comment }}</p>
								</div>
							</div>
						</div>
					</div>
					@endforeach

					<div class="card" id="write-comment">
						<div class="card-header">
							<h5 class="mb-0">Write Your Comment</h5>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label for="">Your Name <span class="text-danger">*</span></label>
										<input type="text" name="name" class="form-control" placeholder="Enter your name." required value="{{ old('name') }}">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="mb-3">
										<label for="">Your Email <span class="text-danger">*</span></label>
										<input type="text" name="email" class="form-control" placeholder="Enter your email." required value="{{ old('email') }}">
									</div>
								</div>
							</div>

							<div class="mb-3">
								<label for="">Your Comment: <span class="text-danger">*</span></label>
								<textarea name="comment" rows="3" class="form-control" required></textarea>
							</div>
						
							<button type="submit" class="btn btn-dark">
								<i class="fas fa-save"></i> Submit
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<x-ablog-blog:sidebar />
			</div>
		</div>	

		<hr class="mt-5">
		<h3 class="fw-bold">Latest Posts</h3>		
		<x-ablog-blog:post-gallery type="latest" />	
	</div>
</x-app-layout>