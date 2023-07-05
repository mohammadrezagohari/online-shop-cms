<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory,SoftDeletes;


    public function province(){
        return $this->belongsTo(Province::class);
    }

}
