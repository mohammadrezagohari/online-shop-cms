<?php

namespace App\Repositories\MySQL\ProductRateRepository;

use App\Models\Market\ProductRate;
use App\Repositories\MySQL\BaseRepository;

class ProductRateRepository extends BaseRepository implements InterfaceProductRateRepository{

    protected ProductRate $model;

    public function __construct(ProductRate $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}