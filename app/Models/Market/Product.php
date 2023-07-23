<?php

namespace App\Models\Market;

use App\Models\Market\ProductColor;
use App\Models\Market\ProductImage;
use App\Models\Market\ProductProperty;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\Product
 *
 * @property int $id
 * @property string $name
 * @property string $introduction
 * @property int $status
 * @property int $marketable 1 => marketable, 0 => is not marketable
 * @property int $sold_number
 * @property int $frozen_number
 * @property int $marketable_number
 * @property int $brand_id
 * @property int $category_id
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductProperty> $Properties
 * @property-read int|null $properties_count
 * @property-read \App\Models\Market\Brand $brand
 * @property-read \App\Models\Market\ProductCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductColor> $colors
 * @property-read int|null $colors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market\Guarantee> $guarantees
 * @property-read int|null $guarantees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFrozenNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMarketable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMarketableNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSoldNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory,SoftDeletes;


    protected  $guarded=['id'];



    public function user()
    {
        return $this->belongsToMany(User::class,'user_id');
    }


    public function guarantees():HasMany
    {
        return $this->hasMany(Guarantee::class,'guarantee_id');
    }


    public function category():BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function amazingSales():HasMany
    {
        return $this->hasMany(AmazingSale::class);
    }

    public function activeAmazingSales()
    {
        return $this->amazingSales()->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->where('status','=',1)->first();
    }


    public function orders():BelongsToMany
    {
        return  $this->belongsToMany(Order::class,'order_product');
    }

    public function colors():HasMany
    {
        return $this->hasMany(ProductColor::class);
    }


    public function images():HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public  function scopeWhereName($query,$name)
    {
        return $query->where('name','like',"%{$name}%");
    }

    public function scopeWhereStatus($query ,$status)
    {
        return $query->where('status','=',$status);

    }

}
