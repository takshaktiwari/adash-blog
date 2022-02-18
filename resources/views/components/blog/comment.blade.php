<div {{ $attributes->merge(['class' => 'row']) }} id="{{ strtotime($comment->created_at) }}">
	<div class="col-md-{{ isset($col) ? $col : 12 }} ms-auto">
		<div class="card">
			<div class="card-body bg-{{ $bg }}">
				<div class="row">
					<div class="col-lg-2 col-3 text-center">
						<img src="{{ route('imgr.placeholder', ['w' => 80, 'h' => 80, 'text' => substr($comment->name, 0, 2)]) }}" alt="image" class="rounded-circle w-100">
					</div>
					<div class="col-lg-10 col-9 my-auto">
						<p class="mb-0 fw-bold">{{ $comment->name }}</p>
						<p class="mb-1 small fw-normal text-secondary">
							<span class="small">{{ $comment->created_at->format('D, d-M-Y H:i') }}</span>
							<a href="#write-comment" class="reply_btn small" data-reply_name="{{ $comment->name }}" data-parent="{{ $comment?->parent?->id ? $comment?->parent?->id : $comment->id }}"><i class="fas fa-share"></i> Reply</a>
						</p>
						<p class="mb-0 small">
							@if($comment->reply_to_name)
								<a href="" class="badge border text-primary text-decoration-none">
									@ {{ $comment->reply_to_name }}
								</a>
							@endif
							{{ $comment->comment }}
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>