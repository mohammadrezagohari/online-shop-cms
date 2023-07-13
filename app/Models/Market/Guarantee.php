<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\Guarantee
 *
 * @property int $id
 * @property string $name
 * @property int $product_id
 * @property string $price_increase
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Market\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee wherePriceIncrease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guarantee withoutTrashed()
 * @mixin \Eloquent
 */
class Guarantee extends Model
{
    use HasFactory, SoftDeletes;

    protected  $table="guarantees";

    protected $fillable = [
        'name',
        'product_id',
        'price_increase',
        'status'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeWhereName($query,$name)
    {
        return $query->where('name','like',"%{$name}%");
    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }
}
