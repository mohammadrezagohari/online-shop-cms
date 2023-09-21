<?php

namespace App\Repositories\MySQL\ConditionRepository;

use App\Models\Condition;
use App\Repositories\MySQL\BaseRepository;

class ConditionRepository extends BaseRepository implements InterfaceConditionRepository{

    protected Condition $model;

    public function __construct(Condition $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}