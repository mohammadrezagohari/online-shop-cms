<?php

namespace App\Repositories\MySQL\PostRepository;


use App\Models\Market\Post;
use App\Repositories\MySQL\BaseRepository;

class PostRepository extends BaseRepository implements InterfacePostRepository
{
    protected Post $model;

    public function __construct(Post $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
