<?php

namespace App\Repositories\MySQL\HelpSizeRepository;

use App\Models\Market\HelpSize;
use App\Repositories\MySQL\BaseRepository;

class HelpSizeRepository extends BaseRepository implements InterfaceHelpSizeRepository{

    protected HelpSize $model;

    public function __construct(HelpSize $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}