<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\CartItem
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $color_id
 * @property int $guarantee_id
 * @property int $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Market\ProductColor $color
 * @property-read \App\Models\Market\Guarantee $guarantee
 * @property-read \App\Models\Market\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereGuaranteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem withoutTrashed()
 * @mixin \Eloquent
 */
class CartItem extends Model
{
    use HasFactory,SoftDeletes;
protected  $guarded=['id'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function guarantee():BelongsTo
    {
        return $this->belongsTo(Guarantee::class);
    }


    public function color():BelongsTo
    {
        return $this->belongsTo(ProductColor::class);
    }


    public function  scopeWhereUserId($query,$user_id){

        return $query->where('user_id','=',$user_id);
    }

    public function  scopeWhereProductId($query,$product_id){

        return $query->where('product_id','=',$product_id);
    }  public function  scopeWhereColorId($query,$color_id){

    return $query->where('color_id','=',$color_id);
}  public function  scopeWhereGuaranteeId($query,$guarantee_id){

    return $query->where('guarantee_id','=',$guarantee_id);
}
}
