<x-admin.layout>
	<x-admin.breadcrumb 
		title='Blog Posts'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Posts'],
		]"
        :actions="[
            ['text' => 'Filter', 'icon' => 'fas fa-sliders-h', 'url' => route('admin.blog.posts.index', ['filter' => 1]), 'permission' => 'blog_posts_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'New Post', 'icon' => 'fas fa-plus', 'url' => route('admin.blog.posts.create'), 'permission' => 'blog_posts_create', 'class' => 'btn-dark btn-loader'],
        ]" />

    @if(request()->get('filter'))
        <form class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="">Search </label>
                            <input type="text" name="search" class="form-control" value="{{ request()->get('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="">Parent Category </label>
                            <select name="category_id" id="category_id" class="form-control select2" >
                                <option value="">-- Select --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (request()->get('category_id') == $category->id) ? 'selected' : '' }} >
                                        @if($category->parentCategory)
                                            {{ $category->parentCategory->name }}
                                            ->
                                        @endif
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="">Status </label>
                            <select name="status" class="form-control" >
                                <option value="">-- Select --</option>
                                <option value="1" {{ (request()->get('status') == '1') ? 'selected' : '' }} >Yes</option>
                                <option value="0" {{ (request()->get('status') == '0') ? 'selected' : '' }} >No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="">Featured </label>
                            <select name="featured" class="form-control" >
                                <option value="">-- Select --</option>
                                <option value="1" {{ (request()->get('featured') == '1') ? 'selected' : '' }} >Yes</option>
                                <option value="0" {{ (request()->get('featured') == '0') ? 'selected' : '' }} >No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-dark btn-loader" name="filter" value="1">
                    <i class="fas fa-search"></i> Submit
                </button>
                <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
        </form>
    @endif
	
    <div class="card shadow-sm">
        <x-admin.paginator-info :items="$posts" class="card-header" />
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($posts as $key => $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('blog.posts.show', [$post]) }}" target="_blank">
                                    <img src="{{ $post->image_sm() }}" alt="image" width="90" class="rounded">
                                </a>
                            </td>
                            <td>
                                <lc class="2">{{ $post->title }}</lc>
                                <div class="small">
                                    {{ $post->categories->pluck('name')->implode(', ') }}
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', [$post->user]) }}" class="d-block">
                                    {{ $post->user?->name }}
                                </a>
                                <div class="small text-nowrap">{{ $post->created_at->format('d-M-y h:i a') }}</div>
                            </td>
                            <td>
                                <a href="{{ route('admin.blog.posts.status-toggle', [$post]) }}" class="d-block {{ $post->status ? 'fw-5 text-success' : 'text-danger' }}">
                                    {{ $post->status ? 'Active' : 'In-Active' }}
                                </a>

                                <a href="{{ route('admin.blog.posts.featured-toggle', [$post]) }}" class="d-block text-nowrap {{ $post->featured ? 'fw-5 text-success' : 'text-danger' }}">
                                    {{ $post->featured ? 'Featured' : 'Not-Featured' }}
                                </a>
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.blog.posts.show', [$post]) }}" class="btn btn-sm btn-info btn-loader load-circle">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('admin.blog.posts.edit', [$post]) }}" class="btn btn-sm btn-success btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blog.posts.destroy', [$post]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-alert btn-loader load-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <div class="small text-nowrap">{{ $post->updated_at->format('d-M-y h:i a') }}</div>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>        
        </div>
        <div class="card-footer">
            {{ $posts->links() }}
        </div>
    </div>
    
</x-admin.layout>
