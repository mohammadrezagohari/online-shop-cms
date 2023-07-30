<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\Post
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string|null $image
 * @property int $status
 * @property int $commentable 0 => uncommentable, 1 => commentable
 * @property int $user_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Market\PostCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCommentable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withoutTrashed()
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=['id'];


    public function user():BelongsTo
    {
     return   $this->belongsTo(User::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function comments():MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeWhereStatus($query ,$status)
    {
        return $query->where('status','=',$status);
    }


    public function scopeWhereTitle($query ,$title)
    {
        return $query->where('title','like',"%{$title}%");
    }



    public function scopeWhereUserId($query ,$userId)
    {
        return $query->where('user_id','=',$userId);
    }


    public function scopeWhereCategoryId($query ,$category_id)
    {
        return $query->where('category_id','=',$category_id);
    }
}
