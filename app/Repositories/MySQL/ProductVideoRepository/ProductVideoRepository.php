<?php

namespace App\Repositories\MySQL\ProductVideoRepository;

use App\Models\Market\ProductVideo;
use App\Repositories\MySQL\BaseRepository;

class ProductVideoRepository extends BaseRepository implements InterfaceProductVideoRepository{

    protected ProductVideo $model;

    public function __construct(ProductVideo $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}