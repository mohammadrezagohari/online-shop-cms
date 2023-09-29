<?php

namespace App\Http\Resources\wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount'=>$this->amount,
            'has_credit'=>$this->has_credit,
            'user'=>$this->user,
            'status'=>$this->status
        ];
    }
}
