<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Join extends Model
{
    use HasFactory,SoftDeletes;

    protected  $table="join_us";


    protected $fillable=["first_name","last_name","email","company_name","referral_code","mobile","brands","brand_registration","status"];

    public function scopeWhereFirstName($query,$first_name)
    {
        return $query->where("first_name","like","%{$first_name}%");
    }
    public function scopeWhereLastName($query,$last_name)
    {
        return $query->where("last_name","like","%{$last_name}%");
    }
    public function scopeWhereEmail($query,$email)
    {
        return $query->where("email","like","%{$email}%");
    }
    public function scopeWhereCompanyName($query,$company_name)
    {
        return $query->where("company_name","like","%{$company_name}%");
    }
    public function scopeWhereMobile($query,$mobile)
    {
        return $query->where("mobile","like","%{$mobile}%");
    }
    public function scopeWhereBrandRegistration($query,$brand_registration)
    {
        return $query->where("brand_registration","like","%{$brand_registration}%");
    }
    public function scopeWhereStatus($query,$status)
    {
        return $query->where("status","like","%{$status}%");
    }
}
