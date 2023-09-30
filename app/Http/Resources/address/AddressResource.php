<?php

namespace App\Http\Resources\address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user'=>$this->user,
            'province'=>$this->province,
            'city'=>$this->city,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'unit' => $this->unit,
            'recipient_first_name' => $this->recipient_first_name,
            'recipient_last_name' => $this->recipient_last_name,
            'recipient_mobile' => $this->mobile,
            'recipient_national_code' => $this->national_code,
            'status' => $this->status,

        ];
    }
}
