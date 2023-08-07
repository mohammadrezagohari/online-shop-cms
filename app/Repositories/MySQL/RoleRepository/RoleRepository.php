<?php

namespace App\Repositories\MySQL\RoleRepository;


use Spatie\Permission\Models\Role;
use App\Repositories\MySQL\BaseRepository;

class RoleRepository extends BaseRepository implements InterfaceRoleRepository{

    protected Role  $model;

    public function __construct(Role $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}
