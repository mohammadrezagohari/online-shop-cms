<?php

namespace App\Http\Resources\tranaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'bank'=>$this->bank,
            'subject'=>$this->subject,
            'trace_number'=>$this->trace_number,
            'document_number'=>$this->document_number,
            'digital_receipt'=>$this->digital_receipt,
            'is_suer_bank'=>$this->is_suer_bank,
            'card_number'=>$this->card_number,
            'access_token'=>$this->access_token,
            'status'=>$this->status,
            'payload'=>$this->payload,
            'user_id'=>$this->user,
            'order_id'=>$this->order,
        ];
    }
}
