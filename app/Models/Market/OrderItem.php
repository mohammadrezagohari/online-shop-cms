<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Market\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $number
 * @property string|null $final_product_price
 * @property string|null $final_total_price number * final_product_price
 * @property int|null $color_id
 * @property int|null $guarantee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Market\ProductColor|null $color
 * @property-read \App\Models\Market\Guarantee|null $guarantee
 * @property-read \App\Models\Market\Order $order
 * @property-read \App\Models\Market\Product $singleProduct
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereFinalProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereFinalTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereGuaranteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem withoutTrashed()
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function singleProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

  

    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }

  
}
