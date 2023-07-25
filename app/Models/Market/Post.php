<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
