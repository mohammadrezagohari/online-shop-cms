<?php

namespace App\Http\Resources\rateAverage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateAverageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "product"=>$this->product,
            "product_category_question_id"=>$this->productCategoryQuestion,
            "average_rate"=>$this->average_rate,
            "insert_rate_count"=>$this->insert_rate_count,
            "status"=>$this->status,

        ];
    }
}
