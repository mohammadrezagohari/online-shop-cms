<?php

namespace App\Repositories\MySQL\ProductRepository;

use App\Models\Product;
use App\Repositories\MySQL\BaseRepository;

class ProductRepository extends BaseRepository implements InterfaceProductRepository{

    protected Product $model;

    public function __construct(Product $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}