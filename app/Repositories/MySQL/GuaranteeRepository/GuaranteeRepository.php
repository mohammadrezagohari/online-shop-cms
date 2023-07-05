<?php

namespace App\Repositories\MySQL\GuaranteeRepository;

use App\Models\Market\Guarantee;
use App\Repositories\MySQL\BaseRepository;

class GuaranteeRepository extends BaseRepository implements InterfaceGuaranteeRepository{

    protected Guarantee $model;

    public function __construct(Guarantee $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}