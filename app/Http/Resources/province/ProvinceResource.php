<?php

namespace App\Http\Resources\province;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ProvinceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name
        ];
    }
}
