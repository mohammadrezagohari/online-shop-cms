<?php

namespace App\Repositories\MySQL\CopanRepository;

use App\Models\Market\Copan;
use App\Repositories\MySQL\BaseRepository;

class CopanRepository extends BaseRepository implements InterfaceCopanRepository{

    protected Copan $model;

    public function __construct(Copan $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
