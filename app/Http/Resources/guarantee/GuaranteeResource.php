<?php

namespace App\Http\Resources\guarantee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuaranteeResource extends JsonResource
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
          'product'=>$this->product,
          'price_increase'=>$this->price_increase,
          'status'=>$this->status
        ];
    }
}
