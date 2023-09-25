<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVideo extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable=["product_id","title","url"];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function scopeWhereTitle($query,$title)
    {
        return $query->where('title','like',"%{$title}%");
    }

    public function scopeWhereProductId($query,$product_id)
    {
        return $query->where('product_id','=',$product_id);
    }

    public function scopeWhereUrl($query,$url)
    {
        return $query->where('url','like',"%{$url}%");
    }

}
