<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory,SoftDeletes;


    protected $table="contact_us";
    protected $fillable=['name','email','text','file'];


    public function scopeWhereName($query,$name){
        return $query->where('name','like',"%{$name}%");
    }


    public function scopeWhereEmail($query,$email){
        return $query->where('email','like',"%{$email}%");
    }


    public function scopeWhereText($query,$text){
        return $query->where('text','like',"%{$text}%");
    }
}
