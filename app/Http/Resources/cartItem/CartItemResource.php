<?php

namespace App\Http\Resources\cartItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function App\final_amount_cart_items;

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
            'guarantee'=>$this->guarantee,
            'number'=>$this->number,
            'final_amount'=>final_amount_cart_items($this->number,$this->product->price,$this->color->price_increase ?? 0,$this->guarantee->price_increase ?? 0)

        ];
    }
}
