<?php

namespace App\Repositories\MySQL\CommentRepository;



use App\Repositories\MySQL\IBaseRepository;

interface  InterfaceCommentRepository extends IBaseRepository
{
    public function convertCommentsToSeen();
}
