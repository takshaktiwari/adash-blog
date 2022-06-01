<?php

namespace Takshak\Ablog\Models\Blog;

use Database\Factories\Blog\BlogCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Takshak\Adash\Traits\Models\CommonModelTrait;

class BlogCategory extends Model
{
    use HasFactory, CommonModelTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return BlogCategoryFactory::new();
    }

    /**
     * Get the parentCategory that owns the BlogCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
