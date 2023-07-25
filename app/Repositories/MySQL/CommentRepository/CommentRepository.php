<?php


namespace App\Repositories\MySQL\CommentRepository;



use App\Models\Market\Comment;
use App\Repositories\MySQL\BaseRepository;

class CommentRepository extends BaseRepository implements InterfaceCommentRepository{

    protected Comment $model;

    public function __construct(Comment $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
