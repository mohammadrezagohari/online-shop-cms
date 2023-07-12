<?php

namespace App\Models\Market;

use App\Models\Market\ProductColor;
use App\Models\Market\ProductImage;
use App\Models\Market\ProductProperty;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\Product
 *
 * @property int $id
 * @property string $name
 * @property string $introduction
 * @property string $image
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
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
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



    public function user()
    {
        return $this->belongsToMany(User::class,'user_id');
    }


    public function guarantees()
    {
        return $this->hasMany(Guarantee::class,'guarantee_id');
    }


    public function category(){
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function Properties()
    {
        return $this->hasMany(ProductProperty::class);
    }

    public function colors(){

        return $this->hasMany(ProductColor::class);
    }


    public function images(){

        return $this->hasMany(ProductImage::class);
    }

}
