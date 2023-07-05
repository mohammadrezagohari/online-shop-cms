<?php

namespace App\Repositories\MySQL\ProductCategoryRepository;

use App\Models\Market\ProductCategory;
use App\Repositories\MySQL\BaseRepository;

class ProductCategoryRepository extends BaseRepository implements InterfaceProductCategoryRepository{

    protected ProductCategory $model;

    public function __construct(ProductCategory $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}