<?php

namespace App\Http\Resources\copan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CopanResource extends JsonResource
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
            'code'=>$this->code,
            'amount'=>$this->amount,
            'amount_type'=>$this->amount_type,
            'discount_ceiling'=>$this->discount_ceiling,
            'type'=>$this->type,
            'status'=>$this->status,
            'start_date'=>\Morilog\Jalali\Jalalian::fromCarbon(Carbon::parse($this->start_date))->format('Y-m-d H:i:s'),
            'end_date'=>\Morilog\Jalali\Jalalian::fromCarbon(Carbon::parse($this->end_date))->format('Y-m-d H:i:s'),
            'user'=>$this->user
        ];
    }
}
