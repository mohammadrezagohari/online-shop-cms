<?php

namespace App\Repositories\MySQL\OfflinePaymentRepository;

use App\Models\Market\OfflinePayment;
use App\Repositories\MySQL\BaseRepository;

class OfflinePaymentRepository extends BaseRepository implements InterfaceOfflinePaymentRepository{

    protected OfflinePayment $model;

    public function __construct(OfflinePayment $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}