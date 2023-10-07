<?php

namespace App\Repositories\MySQL\QuestionRepository;

use App\Models\Markert\Question;
use App\Repositories\MySQL\BaseRepository;

class QuestionRepository extends BaseRepository implements InterfaceQuestionRepository{

    protected Question $model;

    public function __construct(Question $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}