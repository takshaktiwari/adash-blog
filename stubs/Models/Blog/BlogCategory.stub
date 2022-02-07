<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\BlogCategory;
use Takshak\Adash\Traits\Models\CommonModelTrait;

class BlogCategory extends Model
{
    use HasFactory, CommonModelTrait;
    protected $guarded = [];

    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }
}
