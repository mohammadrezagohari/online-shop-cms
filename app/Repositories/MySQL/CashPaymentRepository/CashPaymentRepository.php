<?php

namespace App\Repositories\MySQL\CashPaymentRepository;

use App\Models\Market\CashPayment;
use App\Repositories\MySQL\BaseRepository;

class CashPaymentRepository extends BaseRepository implements InterfaceCashPaymentRepository{

    protected CashPayment $model;

    public function __construct(CashPayment $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
}