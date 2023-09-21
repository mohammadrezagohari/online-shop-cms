<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable=["title","description","icon","satus"];


    public function scopeWhereTitle($query,$title)
    {
        return $query->where('title','like',"%{$title}%");
    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }




}
