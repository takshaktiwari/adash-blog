<x-app-layout>
	<x-breadcrumb 
		title="Blog Posts" 
		:links="[
			['text' => 'Blog Posts'],
			['text' => 'List']
		]" />

	<div class="container py-5">
		<div class="row">
			<div class="col-md-8">
				<div class="row g-4">
					@foreach($posts as $post)
						<div class="col-sm-6">
							<x-ablog-blog:post-card :post="$post" />
						</div>
					@endforeach
				</div>

				<div class="post_pagination mt-4">
					{{ $posts->links() }}
				</div>
			</div>
			<div class="col-md-4">
				<x-ablog-blog:sidebar />
			</div>
		</div>	

		<hr class="mt-5">
		<h3 class="fw-bold">Latest Posts</h3>		
		<x-ablog-blog:post-gallery type="latest" />	
	</div>
</x-app-layout>