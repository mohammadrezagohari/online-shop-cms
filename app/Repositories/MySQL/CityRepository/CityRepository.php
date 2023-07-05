<?php

namespace App\Repositories\MySQL\CityRepository;

use App\Models\City;
use App\Repositories\MySQL\BaseRepository;

class CityRepository extends BaseRepository implements InterfaceCityRepository{

    protected City $model;

    public function __construct(City $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}