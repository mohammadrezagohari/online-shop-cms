<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryAttribute extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'unit', 'category_id'];


    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function values()
    {
        return $this->hasMany(CategoryValue::class);
    }


    public function scopeWhereName($query,$name)
    {
        return $query->where('name','like',"%{$name}%");
    }

    public function scopeWhereUnit($query,$unit)
    {
        return $query->where('unit','like',"%{$unit}%");
    }


    public function scopeWhereCategoryId($query,$category_id)
    {
        return $query->where('category_id','=',$category_id);
    }

}