<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\Transaction
 *
 * @property int $id
 * @property float $amount
 * @property int $bank
 * @property string|null $subject
 * @property string|null $trace_number
 * @property string|null $document_number
 * @property string|null $digital_receipt
 * @property string|null $is_suer_bank
 * @property string|null $card_number
 * @property string|null $access_token
 * @property string|null $status
 * @property string|null $payload
 * @property int $user_id
 * @property int $invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDigitalReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereIsSuerBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTraceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withoutTrashed()
 * @property int $order_id
 * @property string|null $message
 * @property string|null $code
 * @property string|null $card_hash
 * @property string|null $card_pan
 * @property string|null $ref_id
 * @property string|null $fee_type
 * @property string|null $fee
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Market\Order $order
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCardHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCardPan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRefId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeWhereBank($query, $bank)
    {
        return $query->where('bank', 'like', "%{$bank}%");
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
