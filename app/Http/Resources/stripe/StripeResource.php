<?php

namespace App\Http\Resources\stripe;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StripeResource extends JsonResource
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
            'order'=>$this->order,
            'user'=>$this->user,
            'session_id'=>$this->session_id,
            'status'=>$this->status,
            'amount_subtotal'=>$this->amount_subtotal,
            'amount_total'=>$this->amount_total,
            'currency'=>$this->currency,
            'email'=>$this->email,

        ];
    }
}
