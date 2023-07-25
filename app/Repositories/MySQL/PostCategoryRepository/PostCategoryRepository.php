<?php

namespace App\Repositories\MySQL\PostCategoryRepository;


use App\Models\Market\PostCategory;
use App\Repositories\MySQL\BaseRepository;

class PostCategoryRepository extends BaseRepository implements InterfacePostCategoryRepository{

    protected PostCategory $model;

    public function __construct(PostCategory $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
