<?php

namespace App\Http\Resources\join;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JoinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'company_name'=>$this->company_name,
            'referral_code'=>$this->referral_code,
            'mobile'=>$this->mobile,
            'brands'=>json_decode($this->brands),
            'brand_registration'=>$this->brand_registration,
            'status'=>$this->status,
        ];
    }
}
