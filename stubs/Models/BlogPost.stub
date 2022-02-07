<?php

namespace App\Models\Blog;

use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Takshak\Adash\Traits\Models\CommonModelTrait;

class BlogPost extends Model
{
    use HasFactory, CommonModelTrait;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
