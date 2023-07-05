<?php

namespace App\Repositories\MySQL\ProductPropertyRepository;

use App\Models\Market\ProductProperty;
use App\Repositories\MySQL\BaseRepository;

class ProductPropertyRepository extends BaseRepository implements InterfaceProductPropertyRepository{

    protected ProductProperty $model;

    public function __construct(ProductProperty $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}