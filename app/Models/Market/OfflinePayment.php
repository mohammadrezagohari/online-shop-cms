<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OfflinePayment extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];


    public function payments()
    {
        return $this->morphMany('App\Models\Market\Payment', 'paymentable');
    }
}