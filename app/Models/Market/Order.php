<?php

namespace App\Models\Market;

use App\Models\User;
use App\Models\Address;
use App\Models\Market\Payment;
use App\Models\Market\Delivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Market\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $address_id
 * @property int|null $payment_id
 * @property int $payment_type
 * @property int $payment_status
 * @property int|null $delivery_id
 * @property string|null $delivery_amount
 * @property int $delivery_status
 * @property string|null $delivery_date
 * @property string|null $order_final_amount
 * @property int $order_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Address|null $address
 * @property-read \App\Models\Market\Delivery|null $delivery
 * @property-read mixed $delivery_status_value
 * @property-read mixed $order_status_value
 * @property-read mixed $payment_status_value
 * @property-read mixed $payment_type_value
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\Market\Payment|null $payment
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderFinalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order withoutTrashed()
 * @property string|null $order_final_amount_with_copan_discount
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderFinalAmountWithCopanDiscount($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function delivery():BelongsTo
    {
        return $this->belongsTo(\App\Models\Market\Delivery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address():BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function products():BelongsToMany
    {
        return  $this->belongsToMany(Product::class,'order_product',);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPaymentStatusValueAttribute()
    {
        switch ($this->payment_status) {
            case 0:
                $result = 'پرداخت نشده';
                break;
            case 1:
                $result = 'پرداخت شده';
                break;
            case 2:
                $result = 'باطل شده';
                break;
            case 3:
                $result = 'برگشت داده شده';
        }
        return $result;
    }

    public function getPaymentTypeValueAttribute()
    {
        switch ($this->payment_type) {
            case 0:
                $result = 'آنلاین';
                break;
            case 1:
                $result = 'آفلاین';
                break;
            case 2:
                $result = 'در محل';
        }
        return $result;
    }

    public function getDeliveryStatusValueAttribute()
    {
        switch ($this->delivery_status) {
            case 0:
                $result = 'ارسال نشده';
                break;
            case 1:
                $result = 'در حال ارسال';
                break;
            case 2:
                $result = 'ارسال شده';
                break;
            case 3:
                $result = 'تحویل شده';
        }
        return $result;
    }


    public function getOrderStatusValueAttribute()
    {
        switch ($this->order_status) {
            case 1:
                $result = 'در انتظار تایید';
                break;
            case 2:
                $result = 'تاییده نشده';
                break;
            case 3:
                $result = 'تایید شده';
                break;
            case 4:
                $result = 'باطل شده';
                break;
            case 5:
                $result = 'مرجوع شده';
                break;
            case 6:
                $result = 'بررسی نشده';
        }
        return $result;
    }


}
