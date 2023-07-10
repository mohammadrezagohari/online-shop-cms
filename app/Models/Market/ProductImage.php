<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory,SoftDeletes;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
