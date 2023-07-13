<?php

namespace App\Http\Resources\delivery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'name'=>$this->name,
          'amount'=>$this->amount,
          'delivery_time'=>$this->delivery_time,
          'delivery_time_unit'=>$this->delivery_time_unit,
          'status'=>$this->status,
        ];
    }
}
