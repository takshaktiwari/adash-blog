<x-admin.layout>
	<x-admin.breadcrumb 
		title='Blog Comments Show'
		:links="[
			['text' => 'Dashboard', 'url' => auth()->user()->dashboardRoute() ],
            ['text' => 'Comments', 'url' => route('admin.blog.comments.index')],
            ['text' => 'Show'],
		]"
        :actions="[
            ['text' => 'All Comments', 'icon' => 'fas fa-sliders-h', 'url' => route('admin.blog.comments.index'), 'permission' => 'blog_comments_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'All Posts', 'icon' => 'fas fa-list', 'url' => route('admin.blog.posts.create'), 'permission' => 'blog_posts_access', 'class' => 'btn-dark btn-loader'],
        ]" />

	
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <tbody>
                    <tr>
                        <td><b>Name:</b></td>
                        <td>{{ $comment->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Email:</b></td>
                        <td>{{ $comment->email }}</td>
                    </tr>
                    @if($comment->user)
                        <tr>
                            <td class="text-nowrap"><b>User:</b></td>
                            <td>
                                <a href="{{ route('admin.users.show', [$comment->user]) }}">
                                    {{ $comment->user->name }}
                                </a>
                                <span class="px-1">|</span>
                                {{ $comment->user->email }}
                            </td>
                        </tr>
                    @endif
                    @if($comment->parent)
                        <tr>
                            <td><b>Parent Comment:</b></td>
                            <td>{{ $comment->parent->comment }}</td>
                        </tr>
                    @endif
                    @if($comment->reply_to_name)
                        <tr>
                            <td><b>Reply To:</b></td>
                            <td>{{ $comment->reply_to_name }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td><b>Post:</b></td>
                        <td>
                            <a href="{{ route('admin.blog.posts.show', [$comment->post]) }}" class="d-block" target="_blank">
                                {{ $comment->post?->title }}
                            </a>
                            {{ $comment->post?->created_at->format('d-M-Y h:i a') }}
                        </td>
                    </tr>
                    <tr>
                        <td><b>Comment:</b></td>
                        <td>{{ $comment->comment }}</td>
                    </tr>
                    @if($comment->children->count())
                        <td>   
                            <td>Children Thread</td>
                            <td>
                                <table class="table mb-0">
                                    @foreach($comment->children as $children)
                                        <tr>
                                            <td>
                                                {{ $children->comment }}
                                                <div class="small">
                                                    {{ $children->created_at->format('d-M-Y H:i') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </td>   
                    @endif
                    <tr>
                        <td class="text-nowrap"><b>Created At:</b></td>
                        <td>{{ $comment->created_at->format('d-M-Y h:i a') }}</td>
                    </tr>
                </tbody>
            </table>        
        </div>
        <div class="card-footer">
            @can('blog_comments_update')
            <a href="{{ route('admin.blog.comments.edit', [$comment]) }}" class="btn btn-success">
                <i class="fas fa-edit"></i> Edit
            </a>
            @endcan
            
            @can('blog_comments_delete')
            <form action="{{ route('admin.blog.comments.destroy', [$comment]) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger delete-alert">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
            @endcan
        </div>
    </div>
    
</x-admin.layout>
