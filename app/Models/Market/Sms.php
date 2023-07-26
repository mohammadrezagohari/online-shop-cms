<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="public_sms";
    protected $guarded=["id"];
    protected $casts=[
        'published_at'=>'datetime',
    ];
}
