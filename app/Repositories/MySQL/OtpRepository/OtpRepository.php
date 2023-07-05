<?php

namespace App\Repositories\MySQL\OtpRepository;

use App\Models\Otp;
use App\Repositories\MySQL\BaseRepository;

class OtpRepository extends BaseRepository implements InterfaceOtpRepository{

    protected Otp $model;

    public function __construct(Otp $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}