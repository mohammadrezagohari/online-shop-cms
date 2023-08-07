<?php

namespace App\Repositories\MySQL\UserRepository;

use App\Models\User;
use App\Repositories\MySQL\BaseRepository;

class UserRepository extends BaseRepository implements InterfaceUserRepository{

    protected User $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
