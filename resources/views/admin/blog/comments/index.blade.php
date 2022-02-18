<x-admin.layout>
	<x-admin.breadcrumb 
		title='Blog Comments'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Comments'],
		]"
        :actions="[
            ['text' => 'Filter', 'icon' => 'fas fa-sliders-h', 'url' => route('admin.blog.comments.index', ['filter' => 1]), 'class' => 'btn-success btn-loader', 'permission' => 'blog_comments_access' ],
            ['text' => 'Create Posts', 'icon' => 'fas fa-plus', 'url' => route('admin.blog.posts.create'), 'permission' => 'blog_posts_create', 'class' => 'btn-dark btn-loader'],
        ]" />

    @if(request()->get('filter'))
        <form class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Search </label>
                            <input type="text" name="search" class="form-control" value="{{ request()->get('search') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">User </label>
                            <input type="text" name="user" class="form-control" value="{{ request()->get('user') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-dark btn-loader" name="filter" value="1">
                    <i class="fas fa-search"></i> Submit
                </button>
                <a href="{{ route('admin.blog.comments.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
        </form>
    @endif
	
    <div class="card shadow-sm">
        <x-admin.paginator-info :items="$comments" class="card-header" />
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Post</th>
                    <th>User</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($comments as $key => $comment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-nowrap">
                                {{ $comment->name }}
                                <div>{{ $comment->email }}</div>
                            </td>
                            <td>
                                <a href="{{ route('admin.blog.posts.show', [$comment->post]) }}" target="_blank" class="lc-2">
                                    {{ $comment->post?->title }}
                                </a>
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ $comment->user ? route('admin.users.show', [$comment->user]) : 'javascript:void(0)' }}">
                                    {{ $comment->user?->name }}
                                </a>
                                <div>{{ $comment->user?->email }}</div>
                            </td>
                            <td class="text-nowrap">
                                @can('blog_comments_show')
                                <a href="{{ route('admin.blog.comments.show', [$comment]) }}" class="btn btn-sm btn-info btn-loader load-circle">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                @endcan

                                @can('blog_comments_update')
                                <a href="{{ route('admin.blog.comments.edit', [$comment]) }}" class="btn btn-sm btn-success btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('blog_comments_delete')
                                <form action="{{ route('admin.blog.comments.destroy', [$comment]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-alert btn-loader load-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                                <div class="small">{{ $comment->created_at->format('d-m-y h:i a') }}</div>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>        
        </div>
        <div class="card-footer">
            {{ $comments->links() }}
        </div>
    </div>
    
</x-admin.layout>
