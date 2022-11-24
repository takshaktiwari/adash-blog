<x-app-layout>
    <x-breadcrumb :title="'Post: ' . $post->title" :links="[['text' => 'Blog Posts', 'url' => route('blog.posts.index')], ['text' => 'Post']]" />

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <img class="card-img-top" src="{{ $post->image_lg() }}" alt="Card image" width="w-100">
                    <div class="card-body">
                        <h4 class="card-title">{{ $post->title }}</h4>
                        <div class="d-flex flex-wrap small">
                            <span class="author">By {{ $post->user->name }}</span>
                            <span class="px-1 text-dark">|</span>
                            <span class="updated_dat">{{ $post->updated_at->format('D, d-M-Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        {!! $post->content !!}
                    </div>
                    @if ($post->categories->count())
                        <div class="card-body border-top post-categories fs-5">
                            @foreach ($post->categories as $category)
                                <a href="{{ route('blog.posts.index', ['category' => $category->slug]) }}"
                                    class="badge bg-primary text-white text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="next-prev-post mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($prevPost)
                                <div class="card prev-post bg-light">
                                    <div class="card-body d-flex">
                                        <a href="{{ route('blog.posts.show', [$prevPost]) }}"
                                            class="display-6 me-3 my-auto">
                                            <i class="fas fa-arrow-left"></i>
                                        </a>
                                        <div class="my-auto">
                                            <h6 class="lc-2 mb-0">{{ $prevPost->title }}</h6>
                                            <span class="text-secondary small">Previous Post</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($nextPost)
                                <div class="card next-post bg-light">
                                    <div class="card-body d-flex">
                                        <div class="my-auto text-end me-3">
                                            <h6 class="lc-2 mb-0">{{ $nextPost->title }}</h6>
                                            <span class="text-secondary small">Next Post</span>
                                        </div>
                                        <a href="{{ route('blog.posts.show', [$nextPost]) }}" class="display-6 my-auto">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="comments mb-5">
                    @if ($post->comments->count())
                        <h3><i class="fa-regular fa-comments"></i> Comments </h3>
                        @foreach ($post->comments as $comment)
                            <x-ablog-blog:comment col="12" :comment="$comment" class="mt-3" />
                        @endforeach
                    @endif

                    @if (config('site.blog.comments'))
                        <form method="POST" action="{{ route('blog.comments.store', [$post]) }}"
                            class="card write-comment mt-4" id="write-comment">
                            @csrf
                            <div class="card-header">
                                <h5 class="mb-0 py-2"><i class="fa-solid fa-pen-nib"></i> Write Your Comment</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="">Your Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter your name." required value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="">Your Email <span class="text-danger">*</span></label>
                                            <input type="text" name="email" class="form-control"
                                                placeholder="Enter your email." required value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="">Your Comment: <span class="text-danger">*</span></label>
                                    <textarea name="comment" rows="3" class="form-control" required>{{ old('comment') }}</textarea>
                                </div>

                                <input type="hidden" name="blog_comment_id" value="{{ old('blog_comment_id') }}">
                                <input type="hidden" name="reply_to_name" value="{{ old('reply_to_name') }}">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save"></i> Submit
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <x-ablog-blog:sidebar />
            </div>
        </div>

        <hr class="mt-5">
        <h3 class="fw-bold">Latest Posts</h3>
        <x-ablog-blog:post-gallery type="latest" />
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $(".comments").on('click', ".replies-btn", function(e) {
                    e.preventDefault();
                    var repliesBtn = $(this);
                    var commentId = $(this).attr('data-comment-id');
                    repliesBtn.attr('disabled', '');

                    $.ajax({
                            type: "POST",
                            url: repliesBtn.attr('href'),
                            data: {
                                '_token': '{{ csrf_token() }}'
                            }
                        })
                        .done((response) => {
                            $("#comment_" + commentId).after(response);
                            repliesBtn.remove();
                        })
                        .fail(() => {
                            repliesBtn.removeAttr('disabled');
                        });
                });

                $(".comments").on('click', ".reply_btn", function(e) {
                    var commentParent = $(this).attr('data-parent');
                    var replyName = $(this).attr('data-reply_name');
                    $("input[name='blog_comment_id']").val(commentParent);
                    $("input[name='reply_to_name']").val(replyName);

                    $("#write-comment .card-body #reply_to_info").remove();
                    $("#write-comment .card-body").prepend(`
						<p id="reply_to_info" class="d-flex">
							<span class="me-1">Reply to: </span>
							<span class="bg-primary text-white d-flex rounded fw-bold">
								<span class="small px-2">@${replyName}</span>
								<span class="border-start px-2" id="remove_reply">
									<i class="fas fa-times cursor-pointer"></i>
								<span>
							<span>
						</p>
					`);
                });

                $("#write-comment").on('click', '#remove_reply', function(event) {
                    event.preventDefault();
                    $("#reply_to_info").remove();
                    $("input[name='blog_comment_id']").val('');
                    $("input[name='reply_to_name']").val('');
                });
            });
        </script>
    @endpush
</x-app-layout>
