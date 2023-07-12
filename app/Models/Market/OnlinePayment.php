<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\OnlinePayment
 *
 * @property int $id
 * @property string $amount
 * @property int $user_id
 * @property string|null $gateway
 * @property int $transaction_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlinePayment withoutTrashed()
 * @mixin \Eloquent
 */
class OnlinePayment extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];


    public function payments()
    {
        return $this->morphMany('App\Models\Market\Payment', 'paymentable');
    }
}