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
							<x-ablog::blog.post-card :post="$post" />
						</div>
					@endforeach
				</div>
			</div>
		</div>				
	</div>
</x-app-layout>