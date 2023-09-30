<?php

namespace App\Http\Resources\userFavoritesProduct;

use App\Http\Resources\resource\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavoritesProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "product"=>ProductResource::make($this->product),
            "user"=>$this->user,
        ];
    }
}
