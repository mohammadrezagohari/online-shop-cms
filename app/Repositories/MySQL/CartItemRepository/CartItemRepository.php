<?php

namespace App\Repositories\MySQL\CartItemRepository;

use App\Models\Market\CartItem;
use App\Repositories\MySQL\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class CartItemRepository extends BaseRepository implements InterfaceCartItemRepository
{

    protected CartItem $model;

    public function __construct(CartItem $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function deleteCollection(int $userId): bool
    {
        return $this->model->where('user_id', '=', $userId)->delete();
    }


    public function findByUserId(int $userId):array|Collection|\Illuminate\Support\Collection
    {
    return $this->model->where('user_id','=',$userId)->get()->toArray();
    }
}
