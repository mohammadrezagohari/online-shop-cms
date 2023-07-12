<?php

namespace App\Http\Resources\city;

use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

/****
 * @mixin City
 */
class CityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'province' => $this->province,
        ];
    }
}
