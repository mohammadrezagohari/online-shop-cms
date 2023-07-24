<?php

namespace App\Repositories\MySQL\CartItemRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceCartItemRepository extends IBaseRepository{
    public function deleteCollection(int $userId);
    public function findByUserId(int $userId):array;
}

