<?php

namespace App\Models\Market;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Market\Copan
 *
 * @property int $id
 * @property string $code
 * @property string $amount
 * @property int $amount_type 0 => percentage, 1 => price unit
 * @property int|null $discount_ceiling
 * @property int $type 0 => common (each user can use one time), 1 => private (one user can use one time)
 * @property int $status
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int|null $user_id
 * @property int|null $number_of_use_code
 * @property int $max_use_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Copan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Copan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Copan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Copan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereAmountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereDiscountCeiling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereMaxUseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereNumberOfUseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Copan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Copan withoutTrashed()
 * @mixin \Eloquent
 */
class Copan extends Model
{
    use HasFactory,SoftDeletes;


    protected  $table="copans";

    protected $guarded=['id'];
    protected $casts=[
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];



    public function scopeWhereCode($query,$code)
    {
        return $query->where('code','=',$code);

    }

    public function scopeWhereStatus($query,$status)
    {
        return $query->where('status','=',$status);
    }
    public function scopeWhereAmountType($query,$amount_type)
    {
        return $query->where('amount_type','=',$amount_type);
    }

    public function scopeWhereType($query,$type)
    {
        return $query->where('type','=',$type);
    }




}
