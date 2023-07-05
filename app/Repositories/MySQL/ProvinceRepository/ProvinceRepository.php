<?php

namespace App\Repositories\MySQL\ProvinceRepository;

use App\Models\Province;
use App\Repositories\MySQL\BaseRepository;

class ProvinceRepository extends BaseRepository implements InterfaceProvinceRepository{

    protected Province $model;

    public function __construct(Province $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}