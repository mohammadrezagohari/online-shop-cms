<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory,SoftDeletes;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }


    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }
}
