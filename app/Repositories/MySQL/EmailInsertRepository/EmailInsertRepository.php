<?php

namespace App\Repositories\MySQL\EmailInsertRepository;


use App\Models\Market\EmailInsert;
use App\Repositories\MySQL\BaseRepository;

class EmailInsertRepository extends BaseRepository implements InterfaceEmailInsertRepository{

    protected EmailInsert $model;

    public function __construct(EmailInsert $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}