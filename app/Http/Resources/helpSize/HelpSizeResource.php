<?php

namespace App\Http\Resources\helpSize;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HelpSizeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'size'=>$this->size,
            'height'=>$this->height,
            'Waist'=>$this->Waist,
            'sleeveـlength'=>$this->sleeveـlength,
            'product'=>$this->product,
            'status'=>$this->status,
        ];
    }
}
