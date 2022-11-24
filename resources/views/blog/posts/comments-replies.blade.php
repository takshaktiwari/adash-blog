<div class="ms-2 ps-2 pt-2 border-start">
    @foreach ($comments as $comment)
        <x-ablog-blog:comment col="12" :comment="$comment" class="{{ $loop->first ? '' : 'mt-2' }}" />
    @endforeach
</div>
