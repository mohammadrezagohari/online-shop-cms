<?php

namespace App\Http\Resources\productSocial;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->title,
            'product'=>$this->product,
            'icon'=>$this->icon,
            'link'=>$this->link,
        ];
    }
}
