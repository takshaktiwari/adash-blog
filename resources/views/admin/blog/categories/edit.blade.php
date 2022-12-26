<x-admin.layout>
	<x-admin.breadcrumb
		title='Blog Categories Edit'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Blog Categories', 'url' => route('admin.blog.categories.index')],
            ['text' => 'Edit'],
		]"
        :actions="[
            ['text' => 'All Categories', 'icon' => 'fas fa-list', 'url' => route('admin.blog.categories.index'),  'permission' => 'blog_categories_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
        ]" />

    <form method="POST" action="{{ route('admin.blog.categories.update', [$category]) }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex">
                        <div class="mr-3">
                            <img src="{{ $category->image_sm() }}" alt="image" width="75">
                        </div>
                        <div class="form-group flex-fill">
                            <label for="">Image </label>
                            <input type="file" name="thumbnail" class="form-control" >
                            <span class="small">
                                Image Size:
                                {{ config('site.blog.images.categories.width') }} x
                                {{ config('site.blog.images.categories.height') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ $category->name }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Parent Category <span class="text-danger">*</span></label>
                        <select name="blog_category_id" id="blog_category_id" class="form-control select2" >
                            <option value="">-- Select --</option>
                            @foreach($categories as $l_category)
                                <option value="{{ $l_category->id }}" {{ ($category->blog_category_id == $l_category->id) ? 'selected' : '' }} >
                                    {{ $l_category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1" {{ ($category->status == '1') ? 'selected' : '' }} >Yes</option>
                            <option value="0" {{ ($category->status == '0') ? 'selected' : '' }} >No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Featured <span class="text-danger">*</span></label>
                        <select name="featured" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1" {{ ($category->featured == '1') ? 'selected' : '' }} >Yes</option>
                            <option value="0" {{ ($category->featured == '0') ? 'selected' : '' }} >No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Meta Title</label>
                <textarea name="meta_title" rows="2" class="form-control">{{ $category->meta_title }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Meta Keywords</label>
                <textarea name="meta_keywords" rows="2" class="form-control">{{ $category->meta_keywords }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Meta Description</label>
                <textarea name="meta_description" rows="2" class="form-control">{{ $category->meta_description }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>

</x-admin.layout>
