<?php

namespace App\Repositories\MySQL\PermissionRepository;

use Spatie\Permission\Models\Permission;
use App\Repositories\MySQL\BaseRepository;

class PermissionRepository extends BaseRepository implements InterfacePermissionRepository{

    protected Permission $model;

    public function __construct(Permission $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
