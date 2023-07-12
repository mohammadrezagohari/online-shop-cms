<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\OfflinePayment
 *
 * @property int $id
 * @property string $amount
 * @property int $user_id
 * @property string|null $transaction_id
 * @property string $pay_date
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflinePayment withoutTrashed()
 * @mixin \Eloquent
 */
class OfflinePayment extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];


    public function payments()
    {
        return $this->morphMany('App\Models\Market\Payment', 'paymentable');
    }
}