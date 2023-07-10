<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];


    protected $casts = [
        'otp' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSmsAttribute(): int
    {
        return $this->otp;
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
