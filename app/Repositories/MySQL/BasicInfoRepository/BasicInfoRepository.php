<?php

namespace App\Repositories\MySQL\BasicInfoRepository;

use App\Models\BasicInfo;
use App\Repositories\MySQL\BaseRepository;

class BasicInfoRepository extends BaseRepository implements InterfaceBasicInfoRepository{

    protected BasicInfo $model;

    public function __construct(BasicInfo $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}