<?php

namespace App\Repositories\MySQL\RateRepository;

use App\Models\Market\Rate;
use App\Repositories\MySQL\BaseRepository;

class RateRepository extends BaseRepository implements InterfaceRateRepository{

    protected Rate $model;

    public function __construct(Rate $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}