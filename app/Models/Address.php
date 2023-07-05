<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];




    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
