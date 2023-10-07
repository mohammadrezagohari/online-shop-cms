<?php

namespace App\Repositories\MySQL\QuestionCategoryRepository;

use App\Models\Market\QuestionCategory;
use App\Repositories\MySQL\BaseRepository;

class QuestionCategoryRepository extends BaseRepository implements InterfaceQuestionCategoryRepository{

    protected QuestionCategory $model;

    public function __construct(QuestionCategory $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}