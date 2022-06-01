<?php

namespace Takshak\Ablog\Models\Blog;

use App\Models\User;
use Database\Factories\Blog\BlogCommentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogComment extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function newFactory()
    {
        return BlogCommentFactory::new();
    }

    /**
     * Get the post that owns the BlogComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id', 'id');
    }

    /**
     * Get the user that owns the BlogComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the children for the BlogComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Get the parent that owns the BlogComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(BlogComment::class);
    }

    public function scopeHead(Builder $query)
    {
        return $query->whereNull('blog_comment_id');
    }
    public function scopeChildren(Builder $query)
    {
        return $query->whereNotNull('blog_comment_id');
    }
}
