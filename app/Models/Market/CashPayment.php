<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\CashPayment
 *
 * @property int $id
 * @property string $amount
 * @property int $user_id
 * @property string|null $cash_receiver
 * @property string $pay_date
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereCashReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashPayment withoutTrashed()
 * @property-read User $user
 * @mixin \Eloquent
 */
class CashPayment extends Model
{
    use HasFactory,SoftDeletes;
 protected  $table="cash_payments";
 protected $guarded=["id"];

    public function payments()
    {
        return $this->morphMany('App\Models\Market\Payment', 'paymentable');
    }

    public function user():BelongsTo
    {
        return  $this->belongsTo(User::class);
    }


    public function scopeWhereUserId($query,$user_id){
        return $query->where('user_id','=',$user_id);
    }

    public function scopeWhereCashReceiver($query,$cash_receiver){
        return $query->where('cash_receiver','like',"%{$cash_receiver}%");
    }
}
