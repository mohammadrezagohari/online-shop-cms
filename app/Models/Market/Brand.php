<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Market\Product;

/**
 * App\Models\Market\Brand
 *
 * @property int $id
 * @property string $persian_name
 * @property string $original_name
 * @property string $logo
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand wherePersianName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $products
 * @property-read int|null $products_count
 * @mixin \Eloquent
 */
class Brand extends Model
{
    use HasFactory,SoftDeletes;

protected  $guarded=['id'];

    public function products():HasMany
    {
        return $this->hasMany(Product::class,'product_id');
    }


    public  function  scopeWherePersianName($query,$persian_name){
        return $query->whrer('persian_name','=',$persian_name);
    }


    public function scopeWhereOriginalName($query,$original_name){
        return $query->where('original_name','like',"%{$original_name}%");

    }
}
