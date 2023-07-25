<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\AmazingSale
 *
 * @property int $id
 * @property int $product_id
 * @property int $percentage
 * @property int $status
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Market\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale query()
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AmazingSale withoutTrashed()
 * @mixin \Eloquent
 */
class AmazingSale extends Model
{
    use HasFactory,SoftDeletes;


    protected $guarded= ["id"];
    protected  $table="amazing_sales";


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',

    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeWhereProductId($query ,$product_id)
    {
        return $query->where('product_id','=',$product_id);
    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }


}


