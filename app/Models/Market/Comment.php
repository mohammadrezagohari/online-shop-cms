<?php

namespace App\Models\Market;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
