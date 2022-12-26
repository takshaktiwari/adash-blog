<x-admin.layout>
    <x-admin.breadcrumb title='Blog Posts Edit' :links="[
        [
            'text' => 'Dashboard',
            'url' => auth()
                ->user()
                ->dashboardRoute(),
        ],
        ['text' => 'Posts', 'url' => route('admin.blog.posts.index')],
        ['text' => 'Edit'],
    ]" :actions="[
        [
            'text' => 'All Posts',
            'icon' => 'fas fa-list',
            'url' => route('admin.blog.posts.index'),
            'permission' => 'blog_posts_access',
            'class' => 'btn-success btn-loader',
        ],
        [
            'text' => 'New Post',
            'icon' => 'fas fa-plus',
            'url' => route('admin.blog.posts.create'),
            'permission' => 'blog_posts_create',
            'class' => 'btn-dark btn-loader',
        ],
    ]" />

    <form method="POST" action="{{ route('admin.blog.posts.update', [$post]) }}" class="card shadow-sm"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            <div class="form-group">
                <label for="">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required value="{{ $post->title }}">
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="d-flex mb-2">
                        <div class="mr-3">
                            <img src="{{ $post->image_sm() }}" alt="image" width="100" class="rounded">
                        </div>
                        <div class="flex-fill">
                            <label for="">Image </label>
                            <input type="file" name="thumbnail" class="form-control">
                            <span class="small">
                                Image Size:
                                {{ config('site.blog.images.posts.width') }} x
                                {{ config('site.blog.images.posts.height') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1" {{ $post->status == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $post->status == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Categories <span class="text-danger">*</span></label>
                <select name="category_ids[]" id="category_ids" class="form-control select2" multiple required>
                    <option value="">-- Select --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $post->categories->pluck('id')->contains($category->id) ? 'selected' : '' }}>
                            @if ($category->parentCategory)
                                {{ $category->parentCategory->name }} ->
                            @endif
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="">Post Content <span class="text-danger">*</span></label>
                <textarea name="content" rows="4" class="form-control text-editor">{{ $post->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="">Meta Title</label>
                <textarea name="m_title" rows="2" class="form-control">{{ $post->m_title }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Meta Keywords</label>
                <textarea name="m_keywords" rows="2" class="form-control">{{ $post->m_keywords }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Meta Description</label>
                <textarea name="m_description" rows="2" class="form-control">{{ $post->m_description }}</textarea>
            </div>

            <div class="form-check mb-2">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="featured" value="1"
                        {{ $post->featured ? 'checked' : '' }}> Mark as featured
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="commentable" value="1"
                        {{ $post->commentable ? 'checked' : '' }}> Allow Comments on post
                </label>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>

    <x-slot name="script">
        <script src="{{ asset('assets/admin/js/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '.text-editor',
                plugins: 'print preview paste importcss searchreplace autolink autosave directionality code visualblocks visualchars fullscreen image link codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table help',
                toolbar1: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent',
                toolbar2: 'numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview print | insertfile image link codesample',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                height: 400,
                toolbar_mode: 'sliding',
                file_picker_types: 'image',
                images_upload_handler: function(blobinfo, success, failure) {
                    success("data:" + blobinfo.blob().type + ";base64," + blobinfo.base64());
                }
            });
        </script>
    </x-slot>
</x-admin.layout>
