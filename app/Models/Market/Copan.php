<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Copan extends Model
{
    use HasFactory,SoftDeletes;


    protected  $table="copans";

    protected $guarded=['id'];



    public function scopeWhereCode($query,$code)
    {
        return $query->where('code','=',$code);

    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }
    public function scopeWhereAmountType($query,$amount_type)
    {
        return $query->where('amount_type','=',$amount_type);
    }

    public function scopeWhereType($query,$type)
    {
        return $query->where('type','=',$type);
    }

}
