<?php

namespace App\Repositories\MySQL\ArticleRepository;

use App\Models\Market\Article;
use App\Repositories\MySQL\BaseRepository;

class ArticleRepository extends BaseRepository implements InterfaceArticleRepository{

    protected Article $model;

    public function __construct(Article $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}