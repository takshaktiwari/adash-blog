<?php

namespace Takshak\Ablog\Models\Blog;

use App\Models\User;
use Database\Factories\Blog\BlogPostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Takshak\Adash\Traits\Models\CommonModelTrait;

class BlogPost extends Model
{
    use HasFactory, CommonModelTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return BlogPostFactory::new();
    }

    /**
     * The categories that belong to the BlogPost
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class);
    }

    /**
     * Get the user that owns the BlogPost
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the comments for the BlogPost
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }

    public function excerpt($length = 40)
    {
        return Str::words(strip_tags($this->content), $length, ' ...');
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('featured', true);
    }
}
