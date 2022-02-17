<div class="post-gallery">
	<div class="row g-4">
		@foreach($posts as $post)
			<div class="col-lg-4 col-sm-6">
				<x-ablog-blog:post-card :post="$post" />
			</div>
		@endforeach
	</div>
</div>		