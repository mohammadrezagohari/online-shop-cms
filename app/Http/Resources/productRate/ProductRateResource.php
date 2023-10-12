<?php

namespace App\Http\Resources\productRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function App\get_rate_average_for_one_product;

class ProductRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_category_question'=>$this->productCategoryQuestion,
            'rate'=>$this->rate,
            'product'=>$this->product,
            'user_id'=>$this->user,
            'comment'=>$this->comment,
            'status'=>$this->status,
            'average_rate'=>"1",
            'rate_number'=>"2"
        ];
    }
}
