<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Market\ProductProperty
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty withoutTrashed()
 * @mixin \Eloquent
 */
class ProductProperty extends Model
{
    use HasFactory,SoftDeletes;
}
