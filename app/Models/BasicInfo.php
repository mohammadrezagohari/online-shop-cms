<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasicInfo extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['key','value'];



    public function scopeWhereKeyInput($query,$key){
        return $query->where('key','like',"%{$key}%");
    }


    public function scopeWhereValue($query,$value){
        return $query->where('value','like',"%{$value}%");
    }

    
}
