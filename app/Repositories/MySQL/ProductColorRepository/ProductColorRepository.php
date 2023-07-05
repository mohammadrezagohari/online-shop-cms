<?php

namespace App\Repositories\MySQL\ProductColorRepository;

use App\Models\Market\ProductColor;
use App\Repositories\MySQL\BaseRepository;

class ProductColorRepository extends BaseRepository implements InterfaceProductColorRepository{

    protected ProductColor $model;

    public function __construct(ProductColor $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}