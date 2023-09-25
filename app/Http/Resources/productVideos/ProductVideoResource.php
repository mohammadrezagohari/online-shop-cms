<?php

namespace App\Http\Resources\productVideos;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'title'=>$this->title,
            'product'=>$this->product,
            'url'=>$this->url,
            'status'=>$this->status
        ];
    }
}
