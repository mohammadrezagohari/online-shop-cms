<?php

namespace App\Http\Resources\productColor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'color_name'=>$this->color_name,
            'color'=>$this->color,
            'product_id'=>$this->product,
            'price_increase'=>$this->price_increase,
            'status'=>$this->status,
            'sold_number'=>$this->sold_number,
            'frozen_number'=>$this->frozen_number,
            'marketable_number'=>$this->marketable_number,
        ];
    }
}
