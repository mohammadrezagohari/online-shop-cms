<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseInfo
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $section
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo whereValue($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|BaseInfo whereHasKey($key)
 */
class BaseInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'section',
    ];

    public function scopeWhereHasKey($query, $key)
    {
        $query->where('key', '=', $key);
    }

    public function scopeWhereValue($query, $value)
    {
        $query->where('value', '=', $value);
    }

    public function scopeWhereSection($query, $Section)
    {
        $query->where('section', '=', $Section);
    }
}
