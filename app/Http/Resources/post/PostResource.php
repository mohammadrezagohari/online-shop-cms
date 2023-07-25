<?php

namespace App\Http\Resources\post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
          'body'=>$this->body,
          'image'=>$this->image,
          'status'=>$this->status,
          'commentable'=>$this->commentable,
          'user'=>$this->user,
          'post_category'=>$this->category,
        ];
    }
}
