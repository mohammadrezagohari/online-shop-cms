<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property int $province_id
 * @property int $city_id
 * @property string $postal_code
 * @property string $address
 * @property string $unit
 * @property string|null $recipient_first_name
 * @property string|null $recipient_last_name
 * @property string|null $mobile
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereRecipientFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereRecipientLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address withoutTrashed()
 * @property-read \App\Models\City $city
 * @property-read \App\Models\Province $province
 * @property-read mixed $full_address
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function province():BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city():BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    public function getFullAddressAttribute(){
        return $this->province->name."  ".$this->city->name."  ".$this->address."  واحد:  ".$this->unit." کدپستی: ".$this->postal_code."  گیرنده محصول :".$this->recipient_first_name." ".$this->recipient_last_name." تلفن همراه: ".$this->mobile;
    }



    public function scopeWhereUserId($query,$userId){
        return $query->where("user_id","=",$userId);
    }


    public function scopeWherePostalCode($query,$postalCode){
        return $query->where('postal_code','like', "%{$postalCode}%");
    }



}
