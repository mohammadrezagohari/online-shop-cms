<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
     use HasFactory,SoftDeletes;


    protected $table="public_email";
    protected $guarded=["id"];
    protected $casts=[
        'published_at'=>'datetime',
    ];
}
