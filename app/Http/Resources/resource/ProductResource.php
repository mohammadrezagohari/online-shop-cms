<?php

namespace App\Http\Resources\resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'introduction'=>$this->introduction,
            'status'=>$this->status,
            'marketable'=>$this->marketable,
            'sold_number'=>$this->sold_number,
            'frozen_number'=>$this->frozen_number,
            'brand'=>$this->brand,
            'category'=>$this->category,
            'images'=>$this->images,
            'published_at'=>$this->published_at



        ];
    }



}
