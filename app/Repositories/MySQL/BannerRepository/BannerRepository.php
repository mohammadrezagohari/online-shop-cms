<?php

namespace App\Repositories\MySQL\BannerRepository;

use App\Models\Market\Banner;
use App\Repositories\MySQL\BaseRepository;

class BannerRepository extends BaseRepository implements InterfaceBannerRepository{

    protected Banner $model;

    public function __construct(Banner $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}