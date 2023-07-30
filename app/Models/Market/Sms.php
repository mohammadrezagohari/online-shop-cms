<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\Sms
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $status
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms withoutTrashed()
 * @mixin \Eloquent
 */
class Sms extends Model
{
    use HasFactory,SoftDeletes;

    protected $table="public_sms";
    protected $guarded=["id"];
    protected $casts=[
        'published_at'=>'datetime',
    ];


    public function scopeWhereStatus($query ,$status)
    {
        return $query->where('status','=',$status);
    }

    public function scopeWhereTitle($query, $title)
    {
        return $query->where('title','=',$title);
    }
    public function scopeWherePublishedAt($query,$published_at)
    {
        return $query->where('published_at','=',$published_at);
    }
}
