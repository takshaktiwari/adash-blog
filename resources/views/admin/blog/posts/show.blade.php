<x-admin.layout>
	<x-admin.breadcrumb 
		title='Blog Posts Show'
		:links="[
			['text' => 'Dashboard', 'url' => auth()->user()->dashboardRoute() ],
            ['text' => 'Posts', 'url' => route('admin.blog.posts.index')],
            ['text' => 'Show'],
		]"
        :actions="[
            ['text' => 'All Posts', 'icon' => 'fas fa-list', 'url' => route('admin.blog.posts.index'), 'permission' => 'blog_posts_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'New Post', 'icon' => 'fas fa-plus', 'url' => route('admin.blog.posts.create'), 'permission' => 'blog_posts_create', 'class' => 'btn-dark btn-loader'],
        ]" />

    <div class="container">
        <div class="card shadow-sm">
            <img class="card-img-top" src="{{ $post->image_lg() }}" alt="Card image">
            <div class="card-body">
                <h3 class="">{{ $post->title }}</h3>
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="mr-3 fw-4">
                        <b>Posted By:</b> {{ $post->user?->name }}
                        <span class="px-1">|</span>
                        {{ $post->created_at->format('l, d-M-Y h:i A') }}
                    </div>
                    <div>
                        {{ $post->status ? 'Active' : 'In-Active' }}
                        <span class="px-1">|</span>
                        {{ $post->featured ? 'Featured' : 'Not-Featured' }}
                        <span class="px-1">|</span>
                        {{ $post->commentable ? 'Commentable' : 'Non Commentable' }}
                    </div>
                </div>
            </div>
            <div class="card-body border-top">
                {!! $post->content !!}
            </div>
            @if($post->categories->count())
                <div class="card-body border-top">
                    Categories: {{ $post->categories->pluck('name')->implode(', ') }}
                </div>
            @endif
            <div class="card-footer">
                <a href="{{ route('admin.blog.posts.edit', [$post]) }}" class="btn btn-success btn-loader">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.blog.posts.destroy', [$post]) }}" method="POST" class="d-inline-block btn-loader">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete-alert">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    
</x-admin.layout>
