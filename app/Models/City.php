<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $province_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Province $province
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City onlyTrashed()
 * @method static Builder|City query()
 * @method static Builder|City searchByName($name)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereDeletedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereProvinceId($value)
 * @method static Builder|City whereSlug($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @method static Builder|City withTrashed()
 * @method static Builder|City withoutTrashed()
 * @mixin Eloquent
 */
class City extends Model
{
    use HasFactory,SoftDeletes;


    protected $table = "cities";
    protected $fillable = ['name', 'slug', 'province_id'];

    /**************
     * This method for relation to province
     * @return BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }


      #region Scope
      public function scopeWhereProvinceId($query, $provinceId)
      {
          return $query->where('province_id', '=', $provinceId);
      }

      public function scopeSearchByName($query, $name)
      {
          return $query->where('name', 'like', "%{$name}%")->orWhere('slug', 'like', "%{$name}s%");
      }
      #endregion

}
