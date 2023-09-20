<?php

namespace App\Http\Resources\article;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'description'=>$this->description,
            'author'=>$this->author,
            'image'=>$this->image,
            'count_viewer'=>$this->count_viewer,
            'selected_content'=>$this->selected_content,
            'status'=>$this->status,
            'product_category'=>$this->productCategory,
            'article_category'=>$this->articleCategory,
            'created_at' => \Morilog\Jalali\Jalalian::fromCarbon($this->created_at)->format(' %Y  %B  %d '),
            //$this->created_at
        ];
    }
}
