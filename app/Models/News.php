<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=["email","status"];


    public function scopeWhereEmail($query, $email)
    {
        return $query->where('email','like',"%{$email}%");
    }

    public function scopeStaus($query, $status)
    {
        return $query->where('status','=',$status);
    }
}
