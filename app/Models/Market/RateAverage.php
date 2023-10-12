<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RateAverage extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="rate_average";

    protected $fillable=["product_id","product_category_question_id","average_rate","insert_rate_count","status"];



    public function product(){

        return $this->belongsTo(Product::class);
    }

    public function productCategoryQuestion(){
        return $this->belongsTo(ProductCategoryQuestion::class);
    }


    public function scopeWhereProductId($query,$product_id)
    {
        return $query->where("product_id","=",$product_id);
    }
    public function scopeWhereProductCategoryQuestionId($query,$product_category_question_id)
    {
        return $query->where("product_category_question_id","=",$product_category_question_id);
    }
    public function scopeWhereStatus($query,$status)
    {
        return $query->where("status","=",$status);
    }
}
