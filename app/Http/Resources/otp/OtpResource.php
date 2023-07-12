<?php

namespace App\Http\Resources\otp;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtpResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'user'=>$this->user,
            'otp_code'=>$this->otp_code,
            'loginFor'=>$this->login_id==0 ? "mobile" : "email",
            'type'=>$this->type=="0" ?  "mobile" : "email",
            'used'=>$this->used=="0" ? "not used" : "used",
            'expire_at'=>$this->expire_at,
            'status'=>$this->status==0 ? "inactive" : "active",
        ];
    }
}
