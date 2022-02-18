<?php

namespace Takshak\Ablog\View\Components\Blog;
use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Comment extends Component
{
    public function __construct(public $comment, public $col=12, public $bg='white')
    {

    }
    
    public function render()
    {
    	return View::first(['components.blog.comment', 'ablog::components.blog.comment']);
    }
}