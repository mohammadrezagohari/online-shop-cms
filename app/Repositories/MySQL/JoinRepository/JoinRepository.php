<?php

namespace App\Repositories\MySQL\JoinRepository;

use App\Models\Market\Join;
use App\Repositories\MySQL\BaseRepository;

class JoinRepository extends BaseRepository implements InterfaceJoinRepository{

    protected Join $model;

    public function __construct(Join $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}