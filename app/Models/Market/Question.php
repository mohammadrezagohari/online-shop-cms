<?php

namespace App\Models\Market;

use App\Models\Market\QuestionCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=["title","mini_description","full_description","status","category_id","like","dislike"];



    public function questionCategory(){
        return $this->belongsTo(QuestionCategory::class,"category_id");
    }

    public function scopeWhereTitle($query,$title){
        return $query->where("title","like","%{$title}%");
    }


    public function scopeWhereMiniDescription($query,$mini_description){
        return $query->where("mini_description","like","%{$mini_description}%");
    }


    public function scopeWhereFullDescription($query,$full_description){
        return $query->where("full_description","like","%{$full_description}%");
    }


    public function scopeWhereStatus($query,$status){
        return $query->where("status","=",$status);
    }




}
