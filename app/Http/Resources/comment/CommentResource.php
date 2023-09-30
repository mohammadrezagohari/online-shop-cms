<?php

namespace App\Http\Resources\comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'parent'=>$this->parent_id,
            'user'=>$this->user,
            'commentable_id'=>$this->commentable_id,
            'commentable_type'=>$this->commentable_type,
            'suggestion'=>$this->suggestion,
            'approved'=>$this->approved,
            'seen'=>$this->seen,
            'status'=>$this->status,

        ];
    }
}
