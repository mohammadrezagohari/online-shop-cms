<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=["name","description","status"];



    public function scopeWhereName($query,$name)
    {
        return $query->where('name','like',"%{$name}%");
    }

    public function scopeWhereDescription($query,$description)
    {
        return $query->where('description','like',"%{$description}%");
    }


    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status' , '=' , $status);
    }
}
