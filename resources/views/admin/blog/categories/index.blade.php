<x-admin.layout>
	<x-admin.breadcrumb 
		title='Blog Categories'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Categories'],
		]"
        :actions="[
            ['text' => 'Filter', 'icon' => 'fas fa-sliders-h', 'url' => route('admin.blog.categories.index', ['filter' => 1]), 'class' => 'btn-success btn-loader', 'permission' => 'blog_categories_access', ],
            ['text' => 'New Category', 'icon' => 'fas fa-plus', 'url' => route('admin.blog.categories.create'), 'permission' => 'blog_categories_create', 'class' => 'btn-dark btn-loader'],
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
                            <select name="blog_category_id" id="blog_category_id" class="form-control select2" >
                                <option value="">-- Select --</option>
                                @foreach($f_categories as $category)
                                    <option value="{{ $category->id }}" {{ (request()->get('blog_category_id') == $category->id) ? 'selected' : '' }} >
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
                <button type="submit" class="btn btn-dark" name="filter" value="1">
                    <i class="fas fa-search"></i> Submit
                </button>
                <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
        </form>
    @endif
	
    <div class="card shadow-sm">
        <x-admin.paginator-info :items="$categories" class="card-header" />
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($categories as $key => $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $category->image_sm() }}" alt="image" width="50" class="rounded">
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->parentCategory?->name }}</td>
                            <td>
                                <a href="{{ route('admin.blog.categories.status-toggle', [$category]) }}" class="d-block {{ $category->status ? 'fw-5 text-success' : 'text-danger' }}">
                                    {{ $category->status ? 'Active' : 'In-Active' }}
                                </a>

                                <a href="{{ route('admin.blog.categories.featured-toggle', [$category]) }}" class="d-block {{ $category->featured ? 'fw-5 text-success' : 'text-danger' }}">
                                    {{ $category->featured ? 'Featured' : 'Not-Featured' }}
                                </a>
                            </td>
                            <td>
                                @can('blog_categories_update')
                                <a href="{{ route('admin.blog.categories.edit', [$category]) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit btn-loader load-circle"></i>
                                </a>
                                @endcan

                                @can('blog_categories_delete')
                                <form action="{{ route('admin.blog.categories.destroy', [$category]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-alert btn-loader load-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>        
        </div>
        <div class="card-footer">
            {{ $categories->links() }}
        </div>
    </div>
    
</x-admin.layout>
