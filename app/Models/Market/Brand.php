<?php

namespace App\Models\Market;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory,SoftDeletes;



    public function products(){
        return $this->hasMany(Product::class,'product_id');
    }
}
