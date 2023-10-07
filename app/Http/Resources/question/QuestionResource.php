<?php

namespace App\Http\Resources\question;

use App\Http\Resources\questionCategory\QuestionCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"=>$this->title,
            "category"=>QuestionCategoryResource::make($this->questionCategory),
            "mini_description"=>$this->mini_description,
            "full_description"=>$this->full_description,
            "status"=>$this->status,
            "like"=>round(($this->like/($this->like+$this->dislike))*100,2),
            "dislike"=>round(($this->dislike/($this->like+$this->dislike))*100,2),
        ];
    }
}
