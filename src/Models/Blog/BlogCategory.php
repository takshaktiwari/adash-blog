<?php

namespace Takshak\Ablog\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Takshak\Ablog\Models\Blog\BlogCategory as BlogBlogCategory;
use Takshak\Ablog\Models\Blog\BlogPost;
use Database\Factories\Blog\BlogCategoryFactory;
use Illuminate\Database\Eloquent\Model;
use Takshak\Adash\Traits\Models\CommonModelTrait;
use Illuminate\Database\Eloquent\Builder;

class BlogCategory extends Model
{
    use HasFactory;
    use CommonModelTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return BlogCategoryFactory::new();
    }

    /**
     * Get all of the children for the BlogCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(BlogBlogCategory::class);
    }

    /**
     * Get the parentCategory that owns the BlogCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(BlogBlogCategory::class, 'blog_category_id', 'id');
    }

    /**
     * The blogPosts that belong to the BlogCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blogPosts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class);
    }

    public function scopeParent($query=null)
    {
        return $query->whereNull('blog_category_id');
    }

    public function scopeChildren($query=null)
    {
        return $query->whereNotNull('blog_category_id');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('featured', true);
    }
}
