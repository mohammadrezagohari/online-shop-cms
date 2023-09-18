<?php

namespace App\Repositories\MySQL\RateRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceRateRepository extends IBaseRepository{

    public function checkUserInsertProductRate(int $user_id,int $product_id);
    
}

