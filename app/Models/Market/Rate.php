<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory,SoftDeletes;


    protected $guarded=['id'];



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function scopeWhereProductId($query,$product_id)
    {
        return $query->where('product_id','=',$product_id);
    }

    public function scopeWhereUserId($query,$user_id)
    {
        return $query->where('user_id','=',$user_id);
    }
}
