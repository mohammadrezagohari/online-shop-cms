<?php

namespace App\Repositories\MySQL\CartItemRepository;

use App\Models\Market\CartItem;
use App\Repositories\MySQL\BaseRepository;

class CartItemRepository extends BaseRepository implements InterfaceCartItemRepository{

    protected CartItem $model;

    public function __construct(CartItem $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}