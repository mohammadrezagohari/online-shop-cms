<?php

namespace App\Http\Resources\aboutAttachment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutAttachmentResource extends JsonResource
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
            'icon'=>$this->icon,
            'about'=>$this->about

        ];
    }
}
