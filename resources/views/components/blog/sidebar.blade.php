<form action="" class="card mb-4">
	<div class="card-header">
		<h5 class="m-0">Search Here</h5>
	</div>
	<div class="card-body">
		<div class="input-group">
			<input type="text" class="form-control">
			<button class="btn btn-dark">Search</button>
		</div>
	</div>
</form>

<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0">Post Categories</h5>
	</div>
	<div class="card-body">
		<ul class="mb-0">
			@for($i=0; $i<=3; $i++)
				<a href="" class="text-decoration-none">
					<li class="py-1">Lorem, ipsum, dolor.</li>
				</a>
			@endfor
		</ul>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0">Featured Posts</h5>
	</div>
	<div class="card-body">
		@for($i=0; $i<=3; $i++)
		<div class="row mb-3">
			<div class="col-3">
				<img src="https://picsum.photos/300/250" alt="image" class="rounded w-100">
			</div>
			<div class="col-9 my-auto">
				<p class="mb-0">Lorem ipsum dolor, sit amet.</p>
				<p class="small mb-0">{{ now() }}</p>
			</div>
		</div>
		@endfor
	</div>
</div>

<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0">Latest Posts</h5>
	</div>
	<div class="card-body">
		@for($i=0; $i<=3; $i++)
		<div class="row mb-3">
			<div class="col-3">
				<img src="https://picsum.photos/300/250" alt="image" class="rounded w-100">
			</div>
			<div class="col-9 my-auto">
				<p class="mb-0">Lorem ipsum dolor, sit amet.</p>
				<p class="small mb-0">{{ now() }}</p>
			</div>
		</div>
		@endfor
	</div>
</div>

<div class="card mb-4">
	<div class="card-header">
		<h5 class="m-0">Recent Comments</h5>
	</div>
	<div class="card-body">
		@for($i=0; $i<=3; $i++)
			<div class="my-1">
				<p class="mb-0">Lorem ipsum dolor sit amet consectetur.</p>
				<span class="small"><b>Admin Tiwari</b> <em>{{ now() }}</em></span>
			</div>
		@endfor
	</div>
</div>