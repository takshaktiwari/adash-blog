<?php

namespace App\Models\Blog;

use App\Models\Blog\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
