<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Market\ProductColor
 *
 * @property int $id
 * @property string $color_name
 * @property string|null $color
 * @property int $product_id
 * @property string $price_increase
 * @property int $status
 * @property int $sold_number
 * @property int $frozen_number
 * @property int $marketable_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Market\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereColorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereFrozenNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereMarketableNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor wherePriceIncrease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereSoldNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor withoutTrashed()
 * @mixin \Eloquent
 */
class ProductColor extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['color_name', 'color' , 'product_id', 'price_increase', 'status', 'sold_number', 'frozen_number', 'marketable_number'];

 protected  $table="product_colors";

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function  scopeWhereProductId($query,$product_id)
    {

        return $query->where('product_id','=',$product_id);
    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }
}
