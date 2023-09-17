<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailInsert extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="emails";

    protected $fillable=['email','status'];
    


    public function scopeWhereStatus($query,$status){
        return $query->where('status','=',$status);
    }

    public function scopeWhereEmail($query,$email){
        return $query->where('email','like',"%{$email}%");
    }
}
