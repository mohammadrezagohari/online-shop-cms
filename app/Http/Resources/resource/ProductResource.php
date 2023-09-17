<?php

namespace App\Http\Resources\resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function App\get_percentage_from_amazing_sale;
use function App\upload_asset_file;

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
            'id'=>$this->id,
            'name'=>$this->name,
            'price'=>$this->price,
            'introduction'=>$this->introduction,
            'status'=>$this->status,
            'marketable'=>$this->marketable,
            'sold_number'=>$this->sold_number,
            'frozen_number'=>$this->frozen_number,
            'brand'=>$this->brand,
            'category'=>$this->category,
            'images'=>$this->images,
            'product_viewer_counter'=>$this->product_viewer_counter,
            'average_rate'=>$this->average_rate*20,
            'amazing_sales'=>get_percentage_from_amazing_sale($this->id),
            'published_at'=>$this->published_at



        ];
    }



}
