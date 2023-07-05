<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory,SoftDeletes;




    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
