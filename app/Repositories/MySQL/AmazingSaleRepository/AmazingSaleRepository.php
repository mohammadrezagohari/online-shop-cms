<?php

namespace App\Repositories\MySQL\AmazingSaleRepository;

use App\Models\Market\AmazingSale;
use App\Repositories\MySQL\BaseRepository;

class AmazingSaleRepository extends BaseRepository implements InterfaceAmazingSaleRepository{

    protected AmazingSale $model;

    public function __construct(AmazingSale $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
