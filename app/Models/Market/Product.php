<?php

namespace App\Models\Market;

use App\Models\Market\ProductColor;
use App\Models\Market\ProductImage;
use App\Models\Market\ProductProperty;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,SoftDeletes;



    public function user()
    {
        return $this->belongsToMany(User::class,'user_id');
    }


    public function guarantees()
    {
        return $this->hasMany(Guarantee::class,'guarantee_id');
    }


    public function category(){
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function Properties()
    {
        return $this->hasMany(ProductProperty::class);
    }

    public function colors(){

        return $this->hasMany(ProductColor::class);
    }


    public function images(){

        return $this->hasMany(ProductImage::class);
    }

}
