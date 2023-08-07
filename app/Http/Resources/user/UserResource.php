<?php

namespace App\Http\Resources\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'avatar'=>$this->avatar,
            'email'=>$this->email,
            'mobile'=>$this->mobile,
            'national_code'=>$this->national_code,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email_verified_at'=>$this->email_verified_at,
            'mobile_verified_at'=>$this->mobile_verified_at,
            'activation'=>$this->activation,
            'user_type'=>$this->user_type,
            'status'=>$this->status,
        ];
    }
}
