<?php

namespace App\Repositories\MySQL\ProductForbidenRepository;

use App\Models\Market\ProductForbiden;
use App\Repositories\MySQL\BaseRepository;

class ProductForbidenRepository extends BaseRepository implements InterfaceProductForbidenRepository{

    protected ProductForbiden $model;

    public function __construct(ProductForbiden $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}