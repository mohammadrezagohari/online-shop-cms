<?php

namespace App\Http\Resources\productCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
            'description'=>$this->description,
            'image'=>$this->image,
            'status'=>$this->status,
            'show_in_menu'=>$this->show_in_menu,
            'parent'=>$this->parent,
            'children'=>$this->children
        ];
    }
}
