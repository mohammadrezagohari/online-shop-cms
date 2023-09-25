<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSocial extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable=["title","product_id","icon","link"];

    protected $table="product_social";


    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function scopeWhereTitle($query,$title){
        return $query->where('title','like',"%{$title}%");
    }


    public function scopewhereProductId($query,$product_id){
        return $query->where('product_id','=',$product_id);
    }

    public function scopeWhereLink($query,$link){
        return $query->where('link','like',"%{$link}%");
    }
}
