<?php

namespace App\Repositories\MySQL\OrderItemRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceOrderItemRepository extends IBaseRepository{

    public function findByOrderIdAndDelete (int $orderId);

    public function getSumFinalTotalPriceOrderItemsByOrderId(int $orderId);

    public function findOrderItemsWithOrderID(int $orderId);
}

