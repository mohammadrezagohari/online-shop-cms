<?php

namespace App\Repositories\MySQL\AddressRepository;

use App\Models\Address;
use App\Repositories\MySQL\BaseRepository;

class AddressRepository extends BaseRepository implements InterfaceAddressRepository{

    protected Address $model;

    public function __construct(Address $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}