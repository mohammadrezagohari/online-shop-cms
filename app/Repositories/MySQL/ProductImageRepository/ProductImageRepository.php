<?php

namespace App\Repositories\MySQL\ProductImageRepository;

use App\Models\Market\ProductImage;
use App\Repositories\MySQL\BaseRepository;

class ProductImageRepository extends BaseRepository implements InterfaceProductImageRepository{

    protected ProductImage $model;

    public function __construct(ProductImage $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}