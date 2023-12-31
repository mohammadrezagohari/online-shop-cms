<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderStatus extends Model
{
    use HasFactory,SoftDeletes;


    protected $table='order_statuses';

    protected $guarded=['id'];
}
