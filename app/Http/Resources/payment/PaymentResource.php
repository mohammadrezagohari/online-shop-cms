<?php

namespace App\Http\Resources\payment;

use App\Models\Market\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'amount'=>$this->amount,
            'user'=>$this->user,
            'status'=>$this->status,
            'type'=>$this->type,
            'paymentable_id'=>$this->paymentable_id,
            'paymentable_type'=>$this->paymentable_type,
            'paymentable' => Payment::find($this->id)->paymentable ,

        ];
    }
}
