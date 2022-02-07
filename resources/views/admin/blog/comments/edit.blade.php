<x-admin.layout>
	<x-admin.breadcrumb 
		title='Blog Comments Edit'
		:links="[
			['text' => 'Dashboard', 'url' => auth()->user()->dashboardRoute() ],
            ['text' => 'Comments', 'url' => route('admin.blog.comments.index')],
            ['text' => 'Edit'],
		]"
        :actions="[
            ['text' => 'All Posts', 'icon' => 'fas fa-sliders-h', 'url' => route('admin.blog.comments.index'), 'permission' => 'blog_posts_access', 'class' => 'btn-success btn-loader'],
        ]" />

	
    <form method="POST" action="{{ route('admin.blog.comments.update', [$comment]) }}" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ $comment->name }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required value="{{ $comment->email }}">
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <label for="">Comment <span class="text-danger">*</span></label>
                <textarea name="comment" class="form-control" required>{{ $comment->comment }}</textarea>
            </div>     
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>
    
</x-admin.layout>
