<?php

namespace App\Http\Resources\order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function App\order_final_amount;

class OrderResource extends JsonResource
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
            'user'=>$this->user,
            'address'=>$this->address,
            'payment'=>$this->payment,
            'payment_type'=>$this->paymentTypeValue,
            'payment_status'=>$this->paymentStatusValue,
            'delivery'=>$this->delivery,
            'delivery_amount'=>$this->delivery->amount,
            'delivery_status'=>$this->deliveryStatusValue,
            'delivery_date'=>$this->delivery_date,
            'order_final_amount'=>$this->order_final_amount,
            'order_status'=>$this->order_status,
            'order_items'=>$this->orderItems
        ];
    }
}
