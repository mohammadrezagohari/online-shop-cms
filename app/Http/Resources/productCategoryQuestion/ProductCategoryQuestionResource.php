<?php

namespace App\Http\Resources\productCategoryQuestion;

use App\Http\Resources\productCategory\ProductCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'question'=>$this->question,
            "category"=>$this->productCategory
        ];
    }
}
