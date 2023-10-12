<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductForbiden extends Model
{
    use HasFactory,SoftDeletes;



    protected $table="product_forbiden";
    protected $fillable=["title","description"];


    public function scopeWhereTitle($query,$title){
        return $query->where("title","like","%{$title}%");
    }
    public function scopeWhereDescription($query,$description){
        return $query->where("description","like","%{$description}%");
    }
    public function scopeWhereStatus($query,$status){
        return $query->where("status","=",$status);
    }

}
