<?php

namespace App\Repositories\MySQL\AmazingSaleRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceAmazingSaleRepository extends IBaseRepository{

    public function amazingSaleWithProductIdAndActive($productId);
}

