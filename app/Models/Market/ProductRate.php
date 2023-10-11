<?php

namespace App\Models\Market;

use App\Models\User;
use App\Models\Market\ProductCategoryQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRate extends Model
{
    use HasFactory,SoftDeletes;


    protected $table="product_rates";

    protected $fillable=["product_category_question_id","rate","product_id","user_id","comment","status"];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function productCategoryQuestion(){
        return $this->belongsTo(ProductCategoryQuestion::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function scopeWhereProductCategoryQuestion($query,$category_id){
        return $query->where("product_category_question_id","=",$category_id);
    }

    public function scopeWhereRate($query,$rate)
    {
        return $query->where("rate","=",$rate);
    }
    public function scopeProductId($query,$product_id)
    {
        return $query->where("product_id","=",$product_id);
    }
    public function scopeUserId($query,$user_id)
    {
        return $query->where("user_id","=",$user_id);
    }
    public function scopeWhereComment($query,$comment)
    {
        return $query->where("comment","like","%{$comment}%");
    }
    public function scopeWhereStatus($query,$status)
    {
        return $query->where("status","=",$status);
    }
}
