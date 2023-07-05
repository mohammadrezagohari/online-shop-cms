<?php

namespace App\Repositories\MySQL\OrderRepository;

use App\Models\Market\Order;
use App\Repositories\MySQL\BaseRepository;

class OrderRepository extends BaseRepository implements InterfaceOrderRepository{

    protected Order $model;

    public function __construct(Order $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}