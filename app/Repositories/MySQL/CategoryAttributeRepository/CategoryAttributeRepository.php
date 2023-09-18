<?php

namespace App\Repositories\MySQL\CategoryAttributeRepository;

use App\Models\Market\CategoryAttribute;
use App\Repositories\MySQL\BaseRepository;

class CategoryAttributeRepository extends BaseRepository implements InterfaceCategoryAttributeRepository{

    protected CategoryAttribute $model;

    public function __construct(CategoryAttribute $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}