<?php

namespace App\Http\Resources\cashPayment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashPaymentResource extends JsonResource
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
            'amount'=>$this->amount,
            'cash_receiver'=>$this->cash_receiver,
            'pay_date'=>$this->pay_date,
            'status'=>$this->status
        ];
    }
}
