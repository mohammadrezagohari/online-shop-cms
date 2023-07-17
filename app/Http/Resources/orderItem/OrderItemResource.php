<?php

namespace App\Http\Resources\orderItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product'=>$this->product,
            'color'=>$this->color,
            'guarantee'=>$this->guarantee,

        ];
    }
}
