<?php

namespace App\Models\Market;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\Comment
 *
 * @property int $id
 * @property string $body
 * @property int|null $parent_id
 * @property int $user_id
 * @property int $commentable_id
 * @property string $commentable_type
 * @property int $seen 0 => unseen, 1 => seen
 * @property int $approved 0 => not approved, 1 => approved
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $commentable
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment withoutTrashed()
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use HasFactory,SoftDeletes;


    protected $guarded=["id"];


    public function commentable():MorphTo
    {
        return $this->morphTo();
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }

    public function scopeWhereApproved($query,$approved)
    {
        return $query->where('approved','=',$approved);
    }


    public function scopeWhereUserId($query,$userId)
    {
        return $query->where('user_id','=',$userId);
    }
}
