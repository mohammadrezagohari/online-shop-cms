<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCategory extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = ["title"];

    public function scopeWhereTitle($query, $title)
    {
        return $query->where("title", "like", "%{$title}%");
    }
}
