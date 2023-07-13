<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Market\Delivery
 *
 * @property int $id
 * @property string $name
 * @property string|null $amount
 * @property int|null $delivery_time
 * @property string|null $delivery_time_unit
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereDeliveryTimeUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery withoutTrashed()
 * @mixin \Eloquent
 */
class Delivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'delivery';


    protected $fillable = ['name', 'amount', 'delivery_time', 'delivery_time_unit', 'status'];


    public function scopeWhereName($query, $name){
        return $query->where('name','like',"%{$name}%");
    }

    public function scopeWhereStatus($query ,$status)
    {
        return $query->where('status','=',$status);
    }
}
