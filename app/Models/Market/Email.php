<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Market\Email
 *
 * @property int $id
 * @property string $subject
 * @property string $body
 * @property int $status
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Email onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Email query()
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Email withoutTrashed()
 * @mixin \Eloquent
 */
class Email extends Model
{
     use HasFactory,SoftDeletes;


    protected $table="public_email";
    protected $guarded=["id"];
    protected $casts=[
        'published_at'=>'datetime',
    ];


    public function scopeWherePublishedAt($query,$published_at)
    {
        return $query->where('published_at','=',$published_at);
    }


    public function scopeWhereStatus($query ,$status)
    {
        return $query->where('status','=',$status);
    }

    public function scopeWhereSubject($query ,$subject)
    {
        return $query->where('subject','like',"%{$subject}%");
    }
}
