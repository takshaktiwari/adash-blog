<div {{ $attributes->merge(['class' => 'row']) }} id="comment_{{ $comment->id }}">
    <div class="col-md-{{ isset($col) ? $col : 12 }} ms-auto">
        <div class="card">
            <div class="card-body bg-{{ $bg }}">
                <div class="row">
                    <div class="col-lg-2 col-3 text-center">
                        <img src="{{ route('imgr.placeholder', ['w' => 80, 'h' => 80, 'text' => substr($comment->name, 0, 2)]) }}"
                            alt="image" class="rounded-circle w-100">
                    </div>
                    <div class="col-lg-10 col-9 my-auto">
                        <p class="mb-0 fw-bold">{{ $comment->name }}</p>
                        <p class="mb-1 small fw-normal text-secondary">
                            <span class="small">{{ $comment->created_at->format('D, d-M-Y H:i') }}</span>
                            <a href="#write-comment" class="reply_btn small" data-reply_name="{{ $comment->name }}"
                                data-parent="{{ $comment->id }}"><i
                                    class="fas fa-share"></i> Reply</a>
                        </p>
                        <p class="mb-0 small">
                            @if ($comment->reply_to_name)
                                <a href="#comment_{{ $comment->blog_comment_id }}"
                                    class="badge border text-primary text-decoration-none">
                                    @ {{ $comment->reply_to_name }}
                                </a>
                            @endif
                            {{ $comment->comment }}
                        </p>
                        @if ($comment->replies_count)
                            <a href="{{ route('blog.comments.replies', [$comment]) }}"
                                class="badge bg-primary text-decoration-none replies-btn"
                                data-comment-id="{{ $comment->id }}" onclick="return false;">
                                <i class="far fa-comment-dots"></i> Replies {{ $comment->replies_count }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
