<?php

namespace App\Http\Resources\productProperty;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPropertyResource extends JsonResource
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
            'property_key'=>$this->property_key,
            'property_value'=>$this->property_value,
            'product'=>$this->product,

        ];
    }
}
