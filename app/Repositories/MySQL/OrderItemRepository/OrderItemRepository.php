<?php

namespace App\Repositories\MySQL\OrderItemRepository;

use App\Models\Market\OrderItem;
use App\Repositories\MySQL\BaseRepository;

class OrderItemRepository extends BaseRepository implements InterfaceOrderItemRepository{

    protected OrderItem $model;

    public function __construct(OrderItem $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }

    public function findByOrderIdAndDelete(int $orderId): bool
    {
      return $this->model->where('order_id','=',$orderId)->delete();
    }
}
