<?php

namespace App\Http\Resources\categoryAttribute;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAttributeResource extends JsonResource
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
            'unit'=>$this->unit,
            'category'=>$this->category,
        ];
    }
}
