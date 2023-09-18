<?php

namespace App\Repositories\MySQL\CategoryValueRepository;

use App\Models\Market\CategoryValue;
use App\Repositories\MySQL\BaseRepository;

class CategoryValueRepository extends BaseRepository implements InterfaceCategoryValueRepository{

    protected CategoryValue $model;

    public function __construct(CategoryValue $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}