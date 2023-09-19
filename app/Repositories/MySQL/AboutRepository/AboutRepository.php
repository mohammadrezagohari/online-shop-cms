<?php

namespace App\Repositories\MySQL\AboutRepository;

use App\Models\About;
use App\Repositories\MySQL\BaseRepository;

class AboutRepository extends BaseRepository implements InterfaceAboutRepository{

    protected About $model;

    public function __construct(About $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}