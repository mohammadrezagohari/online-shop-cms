<?php

namespace App\Repositories\MySQL\OnlinePaymentRepository;

use App\Models\Market\OnlinePayment;
use App\Repositories\MySQL\BaseRepository;

class OnlinePaymentRepository extends BaseRepository implements InterfaceOnlinePaymentRepository{

    protected OnlinePayment $model;

    public function __construct(OnlinePayment $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}