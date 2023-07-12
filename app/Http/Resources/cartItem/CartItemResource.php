<?php

namespace App\Http\Resources\cartItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'product'=>$this->product,
            'color'=>$this->color,
            'guarantee_id'=>$this->guarantee,
            'number'=>$this->number

        ];
    }
}
