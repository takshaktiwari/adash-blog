<?php

namespace Takshak\Ablog\View\Components\Blog;

use Carbon\Carbon;
use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Comment extends Component
{
    public function __construct(public $comment, public $col = 12, public $bg = 'white')
    {
        if (is_array($this->comment)) {
            $this->comment = json_decode(json_encode($this->comment));
            $this->comment->created_at = Carbon::parse($this->comment->created_at);
        }
    }

    public function render()
    {
        return View::first(['components.blog.comment', 'ablog::components.blog.comment']);
    }
}
