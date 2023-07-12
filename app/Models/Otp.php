<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Otp
 *
 * @property int $id
 * @property string|null $token
 * @property int $user_id
 * @property string $otp_code
 * @property string $login_id 0=> mobile number, 1=>email address
 * @property int $type 0 => mobile number , 1 => email
 * @property int $used 0 => not used , 1 => used
 * @property string|null $expire_at
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $sms
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Otp checkCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Otp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Otp notExpire()
 * @method static \Illuminate\Database\Eloquent\Builder|Otp query()
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereLoginId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereUserId($value)
 * @mixin \Eloquent
 */
class Otp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected $casts = [
        'otp' => 'integer'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSmsAttribute(): int
    {
        return $this->otp;
    }

    public function  scopeWhereLoginType($query,$loginType){

        return $query->where('login_id','=',$loginType);
    }

    public function scopeWhereUserId($query,$userId){
        return $query->where('user_id','=',$userId);
    }



    public function scopeNotExpire($query)
    {
        return $query->where(function ($builder) {
            $builder->where('expire_at', ">=", now()->format("Y-m-d H:i:s"));
        });
    }


    public function scopeCheckCode($query,$code)
    {
        return $query->where(fn ($builder) => $builder->where('otp_code', '=', $code));
    }
}
