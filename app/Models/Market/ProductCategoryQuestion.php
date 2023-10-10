<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategoryQuestion extends Model
{
    use HasFactory,SoftDeletes;


    protected $table="product_category_question";

    protected $fillable=["category_id","question"];



    public function productCategory(){
        return $this->belongsTo(ProductCategory::class,"category_id");
    }


    public function  scopeWhereQuestion($query,$question){
        return $query->where("question","like","%{$question}%");
    }

    public function  scopeWhereCategoryId($query,$category_id)
    {
        return  $query->where("category_id","=",$category_id);
    }
}
