<x-admin.layout>
	<x-admin.breadcrumb
		title='Blog Categories Create'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Blog Categories', 'url' => route('admin.blog.categories.index')],
            ['text' => 'Create'],
		]"
        :actions="[
            ['text' => 'All Categories', 'icon' => 'fas fa-list', 'url' => route('admin.blog.categories.index'), 'permission' => 'blog_categories_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
        ]" />

    <form method="POST" action="{{ route('admin.blog.categories.store') }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Image </label>
                        <input type="file" name="thumbnail" class="form-control" >
                        <span class="small">
                            Image Size:
                            {{ config('site.blog.images.categories.width') }} x
                            {{ config('site.blog.images.categories.height') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Parent Category <span class="text-danger">*</span></label>
                        <select name="blog_category_id" id="blog_category_id" class="form-control select2" >
                            <option value="">-- Select --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('blog_category_id') == $category->id) ? 'selected' : '' }} >
                                    {{ $category->name }}
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
                            <option value="1" {{ (old('status') == '1') ? 'selected' : '' }} >Yes</option>
                            <option value="0" {{ (old('status') == '0') ? 'selected' : '' }} >No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Featured <span class="text-danger">*</span></label>
                        <select name="featured" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1" {{ (old('featured') == '1') ? 'selected' : '' }} >Yes</option>
                            <option value="0" {{ (old('featured') == '0') ? 'selected' : '' }} >No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Meta Title</label>
                <textarea name="meta_title" rows="2" class="form-control">{{ old('meta_title') }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Meta Keywords</label>
                <textarea name="meta_keywords" rows="2" class="form-control">{{ old('meta_keywords') }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Meta Description</label>
                <textarea name="meta_description" rows="2" class="form-control">{{ old('meta_description') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>

</x-admin.layout>
