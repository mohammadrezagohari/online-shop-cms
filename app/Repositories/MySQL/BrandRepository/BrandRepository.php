<?php

namespace App\Repositories\MySQL\BrandRepository;

use App\Models\Market\Brand;
use App\Repositories\MySQL\BaseRepository;

class BrandRepository extends BaseRepository implements InterfaceBrandRepository{

    protected Brand $model;

    public function __construct(Brand $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}