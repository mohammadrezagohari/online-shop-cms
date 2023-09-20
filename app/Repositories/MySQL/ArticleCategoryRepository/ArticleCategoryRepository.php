<?php

namespace App\Repositories\MySQL\ArticleCategoryRepository;

use App\Models\Market\ArticleCategory;
use App\Repositories\MySQL\BaseRepository;

class ArticleCategoryRepository extends BaseRepository implements InterfaceArticleCategoryRepository{

    protected ArticleCategory $model;

    public function __construct(ArticleCategory $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}