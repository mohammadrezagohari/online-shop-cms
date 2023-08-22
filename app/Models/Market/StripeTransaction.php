<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeTransaction extends Model
{
    use HasFactory;


    protected $table="stripe_transactions";

    protected $gurded=['id'];



    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeWhereUserId($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }

    public function scopeWhereOrderId($query, $order_id)
    {
        return $query->where('order_id', '=', $order_id);
    }

    public function scopeWhereStatus($query, $status)
    {

        return $query->where('status', '=', $status);
    }
}
