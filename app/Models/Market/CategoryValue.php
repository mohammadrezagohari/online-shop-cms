<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'category_attribute_id', 'value'];


    public function attribute()
    {
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function scopeWhereProductId($query,$product_id){
        return $query->where('product_id','=',$product_id);
    }


    public function scopeWhereCategoryAttributesId($query,$category_attribute_id){
        return $query->where('category_attribute_id','=',$category_attribute_id);
    }

    public function scopeWhereValue($query,$value){
        return $query->where("value","like","%{$value}%");
    }

}