<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\PostCategory
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory withoutTrashed()
 * @mixin \Eloquent
 */
class PostCategory extends Model
{
    use HasFactory,SoftDeletes;


    protected $guarded=["id"];



}
