<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="wallets";
    protected $fillable=["amount","has_credit","user_id","status"];



    public function user(){
        return $this->belongsTo(User::class);
    }


    public function scopeWhereAmount($query,$amount){
        return $query->where("amount","like","%{$amount}%");
    }
    public function scopeWhereHasCredit($query,$has_credit){
        return $query->where("has_credit","=",$has_credit);
    }
    public function scopeUserId($query,$user_id){
        return $query->where("user_id","=",$user_id);
    }
    public function scopeWhereStatus($query,$status){
        return $query->where("status","=",$status);
    }
}
