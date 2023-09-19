<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutAttachment extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="about_attachment";

    protected $fillable=["about_id","title","icon"];



    public function about()
    {
        return $this->belongsTo(About::class);
    }


    public function scopeWhereTitle($query,$title)
    {
        return  $query->where('title','like',"%{$title}%");
    }


    public function scopeWhereAboutId($query,$about_id)
    {
        return  $query->where('about_id','=',$about_id);
    }

}
