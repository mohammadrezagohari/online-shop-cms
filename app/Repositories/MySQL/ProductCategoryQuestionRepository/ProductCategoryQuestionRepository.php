<?php

namespace App\Repositories\MySQL\ProductCategoryQuestionRepository;

use App\Models\Market\ProductCategoryQuestion;
use App\Repositories\MySQL\BaseRepository;

class ProductCategoryQuestionRepository extends BaseRepository implements InterfaceProductCategoryQuestionRepository{

    protected ProductCategoryQuestion $model;

    public function __construct(ProductCategoryQuestion $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}