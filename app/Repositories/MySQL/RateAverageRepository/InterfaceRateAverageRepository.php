<?php

namespace App\Repositories\MySQL\RateAverageRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceRateAverageRepository extends IBaseRepository{


    public function getRateAverageRowWithProductIdAndProductCategoryQuestionId(int $productId,int $productCategoryQuestionId);

    
    
}

