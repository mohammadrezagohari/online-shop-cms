<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['title','image','url','status'];


    public function scopeWhereTitle($query ,$title)
    {
        return $query->where('title','like',"%{$title}%");
    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }
}
