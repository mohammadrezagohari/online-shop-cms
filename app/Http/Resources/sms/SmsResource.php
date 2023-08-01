<?php

namespace App\Http\Resources\sms;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SmsResource extends JsonResource
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
            'title'=>$this->title,
            'body	'=>$this->body,
            'status'=>$this->status,
            'published_at'=>\Morilog\Jalali\Jalalian::fromCarbon( $this->published_at)->format('Y-m-d H:i:s') ,


        ];
    }
}
