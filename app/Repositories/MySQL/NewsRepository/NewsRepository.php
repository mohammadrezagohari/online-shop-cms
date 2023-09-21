<?php

namespace App\Repositories\MySQL\NewsRepository;

use App\Models\News;
use App\Repositories\MySQL\BaseRepository;

class NewsRepository extends BaseRepository implements InterfaceNewsRepository{

    protected News $model;

    public function __construct(News $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}