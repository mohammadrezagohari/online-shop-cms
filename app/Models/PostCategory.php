<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected  $guarded=["id"];
    protected $table="post_categories";


    public function scopeWhereNameHas($query,$name)
    {

        return $query->where('name',"like","%{$name}%");
    }


    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }


}
