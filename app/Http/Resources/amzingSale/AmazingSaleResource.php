<?php

namespace App\Http\Resources\amzingSale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmazingSaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'product'=>$this->product ,
            'percentage'=>$this->percentage,
            'status'=>$this->status,
            'start_date'=>\Morilog\Jalali\Jalalian::fromCarbon($this->start_date)->format('Y-m-d H:i:s'),
            'end_date'=>\Morilog\Jalali\Jalalian::fromCarbon($this->end_date)->format('Y-m-d H:i:s'),
        ];
    }
}
