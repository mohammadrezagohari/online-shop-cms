<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
     use HasFactory,SoftDeletes;


    protected $table="public_email";
    protected $guarded=["id"];
    protected $casts=[
        'published_at'=>'datetime',
    ];


    public function scopeWherePublishedAt($query,$published_at)
    {
        return $query->where('published_at','=',$published_at);
    }


    public function scopeWhereStatus($query ,$status)
    {
        return $query->where('status','=',$status);
    }

    public function scopeWhereSubject($query ,$subject)
    {
        return $query->where('subject','like',"%{$subject}%");
    }
}
