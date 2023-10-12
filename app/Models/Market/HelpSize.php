<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpSize extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="help_size";

    protected $fillable=["size","height","Waist","sleeveـlength","product_id","status"];



    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopeWhereSize($query,$size)
    {
        return $query->where("size","=",$size);
    }
    public function scopeWhereHeight($query,$height)
    {
        return $query->where("height","=",$height);
    }
    public function scopeWhereWaist($query,$waist)
    {
        return $query->where("waist","=",$waist);
    }
    public function scopeWhereSleeveLength($query,$sleeve_length)
    {
        return $query->where("sleeve_length","=",$sleeve_length);
    }
    public function scopeWhereProductId($query,$product_id)
    {
        return $query->where("product_id","=",$product_id);
    }
    public function scopeWhereStatus($query,$status)
    {
        return $query->where("status","=",$status);
    }
}
