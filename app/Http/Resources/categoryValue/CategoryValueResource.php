<?php

namespace App\Http\Resources\categoryValue;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           
            'product' => $this->product,
            'category_attribute_id' => $this->attribute,
            'value' => $this->value,
        ];
    }
}
