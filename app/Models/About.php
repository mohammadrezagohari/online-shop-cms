<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class About extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['title','description','image'];


    public function Attachments(){
        return $this->hasMany(AboutAttachment::class);
    }


    public function scopeWhereTitle($query,$title)
    {
        return $query->where('title','like',"%{$title}%");
    }


    public function scopeWhereDescription($query,$description)
    {
        return $query->where('description','like',"%{$description}%");
    }

    
}
