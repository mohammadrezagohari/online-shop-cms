<?php

namespace App\Http\Resources\offlinePayment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfflinePaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount'=>$this->amount,
            'user'=>$this->user,
            'transaction_id'=>$this->transaction_id,
            'pay_date'=>$this->pay_date,
            'status'=>$this->status
        ];
    }
}
