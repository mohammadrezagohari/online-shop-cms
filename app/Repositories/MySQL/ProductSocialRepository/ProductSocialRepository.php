<?php

namespace App\Repositories\MySQL\ProductSocialRepository;

use App\Models\Market\ProductSocial;
use App\Repositories\MySQL\BaseRepository;

class ProductSocialRepository extends BaseRepository implements InterfaceProductSocialRepository{

    protected ProductSocial $model;

    public function __construct(ProductSocial $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}